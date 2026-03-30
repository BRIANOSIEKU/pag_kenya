@extends('layouts.admin')

@section('title', 'Admins List')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Admins List</h2>

    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-4">
        + Add New Admin
    </a>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
            <tr>
                <td class="border px-4 py-2">{{ $admin->id }}</td>
                <td class="border px-4 py-2">{{ $admin->name }}</td>
                <td class="border px-4 py-2">{{ $admin->email }}</td>
                <td class="border px-4 py-2">{{ ucfirst($admin->role) }}</td>
                <td class="border px-4 py-2">
                    @if($admin->role === 'admin')
                        <a href="{{ route('admin.admins.reset_password.form', $admin->id) }}" class="btn btn-warning">
                            Reset Password
                        </a>
                    @else
                        <span class="text-gray-500">Cannot reset super admin</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border px-4 py-2 text-center">No admins found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection