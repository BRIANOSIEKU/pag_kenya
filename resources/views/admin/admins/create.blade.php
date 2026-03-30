@extends('layouts.admin')

@section('title', 'Add New Admin')

@section('content')
<div class="container mx-auto p-6 max-w-2xl bg-white rounded-lg shadow-md">
    <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Add New Admin</h2>

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

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Role</label>
            <select name="role"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="admin" selected>Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                Add Admin
            </button>
            <a href="{{ route('admin.admins.list') }}"
               class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition duration-200">
                Back to List
            </a>
        </div>
    </form>
</div>
@endsection