@extends('layouts.admin')

@section('content')
<h2>Reset Password for {{ $admin->name }}</h2>

@if(session('success'))
    <div style="color:green; margin-bottom:10px;">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.admins.reset_password.update', $admin->id) }}" method="POST">
    @csrf

    <div style="margin-bottom:10px;">
        <label>New Password</label><br>
        <input type="password" name="new_password" required>
        @error('new_password')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <div style="margin-bottom:10px;">
        <label>Confirm New Password</label><br>
        <input type="password" name="new_password_confirmation" required>
    </div>

    <button type="submit" class="btn-green">Reset Password</button>
</form>
@endsection