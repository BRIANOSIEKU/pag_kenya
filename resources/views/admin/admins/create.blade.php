@extends('layouts.admin')

@section('title', 'Create New Admin')

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

<div style="max-width:700px; margin:auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.08);">

    <h2 style="margin-bottom:20px; font-size:22px; font-weight:bold;">
        Add New System Administrator
    </h2>

    @if($errors->any())
        <div style="background:#ffebee; color:#c62828; padding:10px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.admins.store') }}" method="POST">

        @csrf

        <!-- Name -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <!-- Email -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <!-- Role -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Assign System Role</label>
            <select name="role" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                <option value="" disabled selected>Select a role...</option>
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="general_secretary">General Secretary</option>
                <option value="general_treasurer">General Treasurer</option>
                <option value="general_superintendent">General Superintendent</option>
            </select>
        </div>

        <!-- Password -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Password</label>
            <input type="password" name="password" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom:20px;">
            <label style="font-weight:bold;">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <!-- Buttons -->
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <a href="{{ route('admin.admins.list') }}" style="color:#555; text-decoration:none;">
                Cancel
            </a>

            <button type="submit" style="
                background:#2196F3;
                color:#fff;
                padding:10px 18px;
                border:none;
                border-radius:6px;
                cursor:pointer;
                font-weight:bold;
            ">
                Create Admin
            </button>
        </div>

    </form>
</div>

@endsection