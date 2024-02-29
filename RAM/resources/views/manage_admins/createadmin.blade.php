@extends('layout')

@section('content')
<div class="container-create-admin">
    <h2>Create New Admin</h2>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('admin.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="text" class="form-control" id="user_id" name="user_id" required>
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="form-group">
            <label for="middle_name">Middle Name (Optional)</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name">
        </div>

        <div class="form-group">
            <label for="email_address">Email Address</label>
            <input type="email" class="form-control" id="email_address" name="email_address" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="admin">Admin</option>
                <option value="superadmin">Superadmin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Admin</button>
    </form>
</div>
@endsection
