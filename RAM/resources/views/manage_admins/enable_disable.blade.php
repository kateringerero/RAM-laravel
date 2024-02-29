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
                    <th>Actions</th>
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
                    <td>
                        @if($admin->is_active)
                            <form action="{{ route('admins.disable', $admin->user_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to disable this admin?')">Disable</button>
                            </form>
                        @else
                            <form action="{{ route('admins.enable', $admin->user_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to enable this admin?')">Enable</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection
