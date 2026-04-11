@extends('layouts.admin')

@section('content')
<div class="p-6">
<h2 class="text-xl font-bold mb-4">Add New Committee</h2>

<form method="POST" action="{{ route('admin.committees.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Committee Name" class="w-full mb-3 p-2 border" required>
    <textarea name="overview" placeholder="Overview" class="w-full mb-3 p-2 border"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2">Save</button>
</form>
</div>
@endsection