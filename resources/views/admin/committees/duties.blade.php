@extends('layouts.admin')

@section('content')
<div class="p-6">
<h2 class="text-xl font-bold mb-4">Duties - {{ $committee->name }}</h2>

<form method="POST" action="#">
    @csrf
    <textarea class="w-full border p-2 mb-3" name="duty"></textarea>
    <button class="bg-indigo-600 text-white px-3 py-2">Save Duty</button>
</form>
</div>
@endsection