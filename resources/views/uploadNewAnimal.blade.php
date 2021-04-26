@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit a new Animal</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('uploadNewAnimal') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">Type of animal</label>

                                <div class="col-md-6">
                                    <input type="text" id="type" name="type">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input type="text" id="name" name="name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age" class="col-md-4 col-form-label text-md-right">Age</label>

                                <div class="col-md-6">
                                    <input type="text" id="age" name="age">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dob"
                                    class="col-md-4 col-form-label text-md-right">Date of birth</label>

                                <div class="col-md-6">
                                    <input type="date" id="dob" name="dob" min="1900-01-01">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">Description</label>

                                <div class="col-md-6">
                                    <input type="text" id="animaldescription" name="animaldescription">
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-8">
                                    <button class="btn btn-primary">
                                        Save
                                    </button>

                                </div>
                            </div>
                        </form>

                         
                          @if ($message = Session::get('success')) 
                              <div class="alert alert-success" style = "margin-top: 5rem">
                                <form action="{{ route('imagesform') }}" method="get">
                                    <input type="hidden" name="animalName" value="{{ Session::get('animalname')}}">
                                    <label for="myanimal"></label>
                                    <button class="btn btn-primary" type ="submit" id="myanimal" name="animal" value= "{{ Session::get('animalid')}}">
                                        Click here to upload images
                                    </button>
                                  </form>  
                              </div>
                          @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection