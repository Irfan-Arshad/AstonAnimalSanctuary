@extends('layouts.app')
@section('content')
<div class="container">
 <div class="row justify-content-center">
 <div class="col-md-8">
 <div class="card">
 <div class="card-header">Dashboard</div>
 <div class="card-body">
    @if (session('status'))
    <div class="alert alert-success">
    {{ session('status') }}
    </div>
    @endif
    <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
    <th> id</th><th> User-id</th><th> Account no</th>
    <th> Type </th><th> balance </th><th> Interest</th>
    </tr>
    </thead>
    <tbody>
   @foreach($accounts as $account)
   <tr>
   <td> {{$account->id}} </td>
   <td> {{$account->userid}} </td>
    <td> {{$account->accountno}} </td>
    <td> {{$account->type}} </td>
   <td> {{$account->balance}} </td>
   <td> {{$account->interest}} </td>
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
   