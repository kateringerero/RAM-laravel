@extends('layout')

@section('sidebar-options')
    <li><a href="{{ route('manage-appointments') }}">Manage Appointments</a></li>
    @if(auth()->check() && auth()->user()->role == 'superadmin')
        <li><a href="/manage-admins">Manage Admins</a></li>
    @endif
    <li><a href="{{ route('my-account') }}">My Account/Profile</a></li>
@endsection

@section('content')

@endsection
