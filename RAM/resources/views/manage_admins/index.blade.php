@extends('layout')

@section('content')
<div class="container-manage-admin">
    <h2>Active Admins</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->user_id }}</td>
                    <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
                    <td>{{ $admin->email_address }}</td>
                    <td>{{ $admin->role }}</td>
                    <td>{{ $admin->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection
