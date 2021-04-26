<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Account;
use App\Models\Images;
use App\Models\User;
use DB;



class AnimalController extends Controller
{
    public function uploadAnimal()
    {
        return view('uploadNewAnimal');
    }

    public function uploadNewAnimal(Request $request)
    {


        $animalModel = new Animal;

        $animalModel->userid = 1;
        $animalModel->type = $request-> type;
        $animalModel->name = $request-> name;
        $animalModel->age = $request-> age;
        $animalModel->dob = $request-> dob;
        $animalModel->description = $request-> animaldescription;
        $animalModel->pendingUsers = "";
        $animalModel->deniedUsers = "";
        $animalModel->save();
        
        return back()
        ->with('success', 'Animal added sucessfully !')
        ->with('animalname', $animalModel->name)
        ->with('animalid', $animalModel->id);
    }  

    public function viewAnimals()
    {

    $animalQuery = Animal::all();
    $imagesQuery = Images::all();
    $account =  Account::all();

    //only display animals which are not already adopted by this user 
    //if (Gate::denies('displayall')) {
        //$animalQuery=$animalQuery->whereNotIn('userid', auth()->user()->id);
        // $account=$account->where('userid', auth()->user()->id);
   // }

    return view('/viewAnimals', array('animals'=>$animalQuery , 'images'=>$imagesQuery, 'myuserid' => auth()->user()->id,'userrole' => auth()->user()->role, 'account' => $account));
    }

    public function imagesForm()
    {
        return view('imagesForm');
    }

    public function imageUpload(Request $request)
    {

        $request->validate([

            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $ImagesModel = new Images;
        
        $ImagesName = time() . '_' . $request->file->getClientOriginalName();
        $Path = $request->file('file')->storeAs('public/Images', $ImagesName);

        $ImagesModel->fileName = basename($Path);
        $ImagesModel->animalid = $request->myanimalid;
        $ImagesModel->save();

        return back()
            ->with('success', 'You have successfully uploaded an image.')
            ->with('file', $ImagesName);
    }

    public function sendRequests(Request $request){

        $animalAdoptionQuery = DB::select('select pendingUsers from animals where id = ?',[$request->myanimalid]);
    
        $pendingstr = $animalAdoptionQuery[0]->pendingUsers;
        
        $pendingstr .= ",".$request->adoptionrequestid; //add user id to string 

        DB::update('update animals set pendingUsers = ? where id = ?',[$pendingstr,$request->myanimalid]);
        
         return back()
         ->with('success', 'You have sucessfuly submitted an adoption request for ' . $request->myanimalname);
    }

    public function adoptionRequestsManagerForm(){

        $myanimalid = $_GET['myanimalid'];

        $animalQuery = DB::select('select * from animals where id = ?',[$myanimalid]);
        $imagesQuery = DB::select('select * from images where animalid = ?',[$myanimalid]);
       
        $approvedOwner = User::all();
        $approvedOwner=$approvedOwner->where('id', $animalQuery[0]->userid);

        $pendingstr = $animalQuery[0]->pendingUsers;
        $pendingusersarray = explode(",", $pendingstr);
        // unset($pendingusersarray[0]);
        $pendingaccountsQuery = DB::table('users')->whereIn('id', $pendingusersarray)->get();

        $deniedstr = $animalQuery[0]->deniedUsers;
        $deniedusersarray = explode(",", $deniedstr);
        // unset($deniedusersarray[0]);
        $deniedaccountsQuery = DB::table('users')->whereIn('id', $deniedusersarray)->get();


        return view('/adoptionRequestManager', array(
            'animals'=>$animalQuery , 
            'images'=>$imagesQuery, 
            'myuserid' => auth()->user()->id ,
            'pendingaccounts' => $pendingaccountsQuery,
            'pendingarray' => $pendingusersarray,
            'deniedaccounts' => $deniedaccountsQuery,
            'deniedarray' => $deniedusersarray,
            'approvedaccount' => $approvedOwner
        ));
}

public function approveAdoptionStatus(Request $request) {
    $accountid = intval($request->approve);
    $usersString = $request->userarray;
    $usersArray = explode(",", $usersString);

    if (($key = array_search($accountid, $usersArray)) !== false) {
        unset($usersArray[$key]); //remove pending user by finding the key which matches the value
    }

    $usersString = implode(",", $usersArray);   //convert array back to string

    $animalAdoptionQuery = DB::select('select deniedUsers from animals where id = ?',[$request->myanimalid]);

    $deniedstr = $animalAdoptionQuery[0]->deniedUsers;
    
    $deniedstr .= $usersString.","; //add user id to string 

    //update pending users string array, and set a new approved user
    DB::update('update animals set userid = ? , pendingUsers = ? , deniedUsers = ? where id = ?',[$accountid,"",$deniedstr,$request->myanimalid]); 

    return back()
    ->with('success', 'You have approved an adoption request');
    
}

public function denyAdoptionStatus(Request $request) {
    $accountid = intval($request->deny);
    $animalid = $request->myanimalid;

    $usersString = $request->userarray;
    $usersArray = explode(",", $usersString);

   
    if (($key = array_search($accountid, $usersArray)) !== false) {
        unset($usersArray[$key]); //remove pending user by finding the key which matches the value
    }

    $usersString = implode(",", $usersArray);   //convert array back to string

    //prepares deniedusers string
    $animalAdoptionQuery = DB::select('select deniedUsers from animals where id = ?',[$request->myanimalid]);

    $deniedstr = $animalAdoptionQuery[0]->deniedUsers;
    
    $deniedstr .= ",".$accountid; //add user id to string 

    //update pending and denied users string array, and set a new approved user
    DB::update('update animals set pendingUsers = ?, deniedUsers = ? where id = ?',[$usersString,$deniedstr,$request->myanimalid]); 

    return back()
    ->with('success', 'You have denied an adoption request');
}

}
