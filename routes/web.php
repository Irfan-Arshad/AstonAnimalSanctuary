<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello',function(){
    return 'Hello World!';
   });
   Route::get('list', 'App\Http\Controllers\AccountController@list');
   Route::get('show/{id}', 'App\Http\Controllers\AccountController@show');
   Route::get('display', [App\Http\Controllers\AccountController::class, 'display'])->name('display_account');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//upload animals routing
Route::get('/upload-animal',[App\Http\Controllers\AnimalController::class, 'uploadAnimal'])->name('uploadAnimal');
Route::post('/upload-animal',[App\Http\Controllers\AnimalController::class, 'uploadNewAnimal'])->name('uploadNewAnimal');

//upload animal images routing
Route::get('/upload-file',[App\Http\Controllers\AnimalController::class, 'createForm']);
Route::post('/upload-file',[App\Http\Controllers\AnimalController::class, 'fileUpload'])->name('fileUpload');

//View animals routing
Route::get('/viewAnimals', [App\Http\Controllers\AnimalController::class, 'viewAnimals'])->name('viewAnimals');
Route::post('/viewAnimals', [App\Http\Controllers\AnimalController::class, 'sendRequests'])->name('adoptionRequest');

//adoption req routing
Route::get('/ManageAdoptionRequest', [App\Http\Controllers\AnimalController::class, 'adoptionRequestsManagerForm'])->name('manageAdoptionRequests');
Route::post('/ManageAdoptionRequest/approve', [App\Http\Controllers\AnimalController::class, 'approveAdoptionStatus'])->name('approveStatus');
Route::post('/ManageAdoptionRequests/deny', [App\Http\Controllers\AnimalController::class, 'denyAdoptionStatus'])->name('denyStatus');


//images form routing
Route::get('/uploadImages', [App\Http\Controllers\AnimalController::class, 'imagesform'])->name('imagesform');
Route::post('/uploadImages', [App\Http\Controllers\AnimalController::class, 'imageUpload'])->name('imageUpload');
