@extends('layouts.admin')

@section('content')

<!-- Back Button -->
<a href="{{ route('admin.admins.list') }}" style="
    padding:8px 12px;
    background:#607D8B;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    margin-bottom:20px;
    display:inline-block;
">
    &larr; Back to Admins List
</a>

<div style="max-width:600px; margin:auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.08);">

    <h2 style="margin-bottom:20px; font-size:22px; font-weight:bold;">
        Reset Password for {{ $admin->name }}
    </h2>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#ffebee; color:#c62828; padding:10px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.admins.reset_password.update', $admin->id) }}" method="POST">

        @csrf

        <!-- New Password -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">New Password</label>
            <input type="password" name="new_password" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom:20px;">
            <label style="font-weight:bold;">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <!-- Buttons -->
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <a href="{{ route('admin.admins.list') }}" style="color:#555; text-decoration:none;">
                Cancel
            </a>

            <button type="submit" style="
                background:#4CAF50;
                color:#fff;
                padding:10px 18px;
                border:none;
                border-radius:6px;
                cursor:pointer;
                font-weight:bold;
            ">
                Reset Password
            </button>
        </div>

    </form>
</div>

@endsection