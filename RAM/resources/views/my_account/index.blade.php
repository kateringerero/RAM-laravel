@extends('layout')

@section('content')
<div class="personal-data">
    <h2>Personal Data</h2>
    <div>
        <label>First Name:</label> <b><span>{{ Auth::user()->first_name }}</span></b>
    </div>
    <div>
        <label>Last Name:</label> <b><span>{{ Auth::user()->last_name }}</span></b>
    </div>
    <div>
        <label>Middle Name:</label> <b><span>{{ Auth::user()->middle_name }}</span></b>
    </div>
    <div>
        <label>Email Address:</label> <b><span>{{ Auth::user()->email_address }}</span></b>
    </div>

    <form action="{{ route('user.update-password') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="_password" name="current_password" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit">Save</button>
    </form>


    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
