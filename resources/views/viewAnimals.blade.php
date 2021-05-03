@extends('layouts.app')
@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>


    <style>
        img.animal {
            border: 1px solid #ddd;
            /* Gray border */
            border-radius: 4px;
            /* Rounded border */
            padding: 5px;
            /* Some padding */
            width: 150px;
            /* Set a small width */
        }

    </style>

    <div class="container">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">

                        @if (session('status'))
                              <div class="alert alert-success">
                                {{ session('status') }}                           
                              </div>
                        @endif

                        {{-- show success message on valid adoprtion request--}}
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif


                        
                            {{-- <strong>{{$account}}</strong> --}}
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Adoption status</th>
                                        <th>Type</th>
                                        <th>name</th>
                                        <th>age</th>
                                        <th>DOB</th>
                                        <th>description </th>
                                        <th>Images</th>
                                        {{-- <th>Images</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($animals as $animal)
                                    {{-- if the animal is owned by someone then skip  --}}
                                        @php   
                                        
                                        $adoptionstatus = false;
                                        $message = "";

                                        if($userrole !== 1)
                                        {                                            
                                                // if the foriegn key matches to myuserid then i own this animal
                                                if ($animal->userid === $myuserid) {
                                                        $message = 
                                                        '
                                                        <div class="alert alert-success">
                                                        <strong>Approved</strong>
                                                        </div>';
                                                        $adoptionstatus = true;
                                                        }
                                                //else check if my user id matches in the table other columns
                                                else{
                                                        $pendingarray = explode(',', $animal->pendingUsers);
                                                        $deniedarray = explode(',', $animal->deniedUsers);
                                                        
                                                        
                                                        foreach ($deniedarray as $user) {
                                                            if (intval($user) === $myuserid) {
                                                                $message = '
                                                        <div class="alert alert-danger">
                                                        <strong>Denied</strong>
                                                        </div>';
                                                                $adoptionstatus = true;
                                                                break;
                                                            }
                                                        }

                                                        foreach ($pendingarray as $user) {
                                                            if (intval($user) === $myuserid) {
                                                                $message = '
                                                        <div class="alert alert-warning">
                                                        <strong>Pending</strong>
                                                        </div>';
                                                                $adoptionstatus = true;
                                                                break;
                                                            }
                                                        }
                                                        
                                                        //animal is owned by someone eles and you have not sent a request
                                                        if($message === "" && $animal->userid !== 1){
                                                            continue;
                                                        }
                                                }
                                        }
                                            
                                        //else if animal is available for adoption
                                         else if($animal->userid ===1){
                                            $message = '<div class="alert alert-info">
                                                <strong>Available for adoption</strong>
                                                </div>';
                                            }
                                        // else the animal is already owned bu someone
                                        else{
                                            $message = '
                                                        <div class="alert alert-success">
                                                        <strong>Approved</strong>
                                                        </div>';
                                        }
                                        @endphp

                                        <tr>
                                            <td>
                                                @php
                                                if($message !== ""){
                                                    echo $message;
                                                }
                                                
                                                @endphp
                                                
                                                {{-- adoption button if no adopted status is recognised --}}
                                                @if ($adoptionstatus === false && $animal->userid === 1 && $userrole !== 1)
                        
                                                <form action="{{route('adoptionRequest')}}" method="post">
                                                    @csrf
                                                        <label for="myanimalid"></label>
                                                        <input type="hidden" id="myanimalid" name="myanimalid" value= "<?php echo $animal->id; ?>" >

                                                        <label for="myanimalname"></label>
                                                        <input type="hidden" id="myanimalname" name="myanimalname" value= "<?php echo $animal->name; ?>" >



                                                        <label for="adoptionrequestid"><div class="alert alert-info">
                                                            <strong>Available for adoption</strong>
                                                            </div></label><br>
                                                        <button class="btn btn-primary" type ="submit" id="adoptionrequestid" name="adoptionrequestid" value= "<?php echo $myuserid ?>">                                 
                                                            Send adoption request
                                                        </button>
                                                </form>
                                            
                                                @endif

                                                @if ($userrole === 1)
                                            <form action="{{route('manageAdoptionRequests')}}" method="get">
                                                @csrf
                                                      <label for="myanimalid"></label>
                                                      <input type="hidden" id="myanimalid" name="myanimalid" value= "<?php echo $animal->id; ?>" >

                                                      <label for="adoptionid"></label><br>
                                                      <button class="btn btn-primary" type ="submit" >                                 
                                                        View/Manage Adoption Requests
                                                      </button>
                                              </form>
                                            
                                            @endif
                                                
                                            </td>
                                            <td> {{ $animal->type }} </td>
                                            <td> {{ $animal->name }} </td>
                                            <td> {{ $animal->age }} </td>
                                            <td> {{ $animal->dob }} </td>
                                            <td> {{ $animal->description }} </td>
                                            <td>
                                                @foreach ($images as $img)
                                                    @php
                                                        //only show the images which match the id of tha animal
                                                        if ($img->animalid !== $animal->id) {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <img class="img animal" src="{{ asset('/storage/Images/' . $img->fileName) }}"/>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection