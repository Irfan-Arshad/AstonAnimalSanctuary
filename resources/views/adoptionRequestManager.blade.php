@extends('layouts.app')
@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>

    <div class="container">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">

                        @if (session('status'))
                              <div class="alert alert-success">
                                {{ session('status') }}                           
                              </div>
                        @endif

                        {{-- show sucess message on successful adoption status modification --}}
                        @if ($message = Session::get('success'))
                          <div class="alert alert-success">
                              <strong>{{ $message }}</strong>
                          </div>
                        @endif

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Users</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($approvedaccount !== null)
                                <tr>
                                    @foreach ($approvedaccount as $account )
                                    @if($account->id !== 1 )
                                    <td> {{ $account->name }} <br>
                                        {{ $account->email}} <br>
                                    </td>
                                    <td>
                                        <div class="alert alert-success">
                                        <strong>Approved</strong>
                                        </div>
                                    </td>
                                </tr>
                                    @break
                                    @endif
                                    @endforeach
                                @endif

                                    @foreach ($pendingaccounts as $account )
                                        <tr> 
                                            @foreach ($pendingarray as &$pendingid )
                                                @if ($account->id === intval($pendingid))
                                                <td> {{ $account->name }} <br>
                                                    {{ $account->email}} <br>
                                                </td>
                                                    <td>
                                                        <div class="alert alert-dark">
                                                        <strong>Pending</strong>
                                                        </div>

                                                        @php
                                                            $strarray = implode(",", $pendingarray);
                                                        @endphp

                                                        <div style = "transform: translateY(-1rem);">
                                                            <form style = "float: left;" method="POST" action="{{ route('denyStatus') }}">
                                                                @csrf
                                                            
                                                            <label for="myanimalid"></label>
                                                            <input type="hidden" id="myanimalid" name="myanimalid" value="{{ $animals[0]->id }}">
        
                                                            <label for="userarray"></label>
                                                            <input type="hidden" id="userarray" name="userarray" value="{{ $strarray }}">

                                                            <label for="deny" class="col-md-4 col-form-label text-md-right"></label>
                                                            <button class = "btn btn-danger" id="deny" name="deny" value = "{{ $account->id}}" >Deny</button>
                                                            </form>
                                                            
                                                            @if ($animals[0]->userid === 1) 
                                                                
                                                            <form style = "float: right;" method="POST" action="{{ route('approveStatus') }}">
                                                                @csrf

                                                            <label for="myanimalid"></label>
                                                            <input type="hidden" id="myanimalid" name="myanimalid" value="{{ $animals[0]->id }}">

                                                            <label for="userarray"></label>
                                                            <input type="hidden" id="userarray" name="userarray" value="{{ $strarray }}">

                                                            <label for="approve" class="col-md-4 col-form-label text-md-right"></label>
                                                            <button type = submit class = "btn btn-success" id="approve" name="approve" value = "{{ $account->id}}">Approve</button>
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    @foreach ($deniedaccounts as $account )
                                    <tr> 
                                        @foreach ($deniedarray as &$deniedid )
                                            @if ($account->id === intval($deniedid))
                                            <td> {{ $account->name }} <br>
                                                {{ $account->email}} <br>
                                            </td>
                                                <td><div class="alert alert-danger">
                                                    <strong>Denied</strong>
                                                    </div></td>
                                            @endif
                                        @endforeach
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