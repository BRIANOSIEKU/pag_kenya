@extends('layouts.admin')

@section('title', 'Reset My Password')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Reset Your Password</h2>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.admins.reset_my_password.submit') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="current_password" class="block text-gray-700">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label for="new_password" class="block text-gray-700">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label for="new_password_confirmation" class="block text-gray-700">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-input w-full" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
@endsection