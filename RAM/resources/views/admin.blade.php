@extends('layout')

@section('sidebar-options')
    <li><a href="{{ route('manage-appointments') }}">Manage Appointments</a></li>
    <li><a href="{{ route('my-account') }}">My Account/Profile</a></li>
@endsection

@section('content')
<h4>testing admin</h4>
@endsection
