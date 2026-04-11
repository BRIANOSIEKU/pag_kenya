@extends('layouts.admin')

@section('content')
<div class="p-6">
<h2 class="text-xl font-bold mb-4">Edit Committee</h2>

<form method="POST" action="{{ route('admin.committees.update', $committee->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $committee->name }}" class="w-full mb-3 p-2 border" required>
    <textarea name="overview" class="w-full mb-3 p-2 border">{{ $committee->overview }}</textarea>

    <button class="bg-blue-600 text-white px-4 py-2">Update</button>
</form>
</div>
@endsection