@extends('layouts.app')

@section('content')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Animal image Upload</title>
</head>

<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload a picutre for  <?php echo $_GET['animalName']; ?></div>
                        <div class="card-body">
                            <form action="{{ route('imageUpload') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                {{-- show sucess message on successful upload --}}
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                    <input type="file" name="file" id="chooseFile">

                                <label for="myanimalid"></label>
                                {{-- get the animal id from url --}}
                                <input type="hidden" id="myanimalid" name="myanimalid"
                                    value="<?php echo $_GET['animal']; ?>">

                                <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                    Upload Files
                                </button>
                            </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
