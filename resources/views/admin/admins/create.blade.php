@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="container mx-auto p-6 max-w-2xl bg-white rounded-lg shadow-md">

    <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">
        Add New System User
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- NAME --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        {{-- ROLE --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Assign Role</label>

            <select name="role" required class="w-full border border-gray-300 rounded px-3 py-2">

                <option value="">-- Select Role --</option>

                <!-- MUST MATCH Spatie roles exactly -->
                <option value="super-admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="general-superintendent">General Superintendent</option>
                <option value="general-secretary">General Secretary</option>
                <option value="general-treasurer">General Treasurer</option>

            </select>
        </div>

        {{-- PASSWORD --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Password</label>
            <input type="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        {{-- CONFIRM --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="flex justify-between mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                Create User
            </button>

            <a href="{{ route('admin.admins.list') }}" class="bg-gray-400 text-white px-6 py-2 rounded">
                Back
            </a>
        </div>

    </form>
</div>
@endsection