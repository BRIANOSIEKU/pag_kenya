@extends('layouts.admin')

@section('content')

<h2>Create District</h2>

<form method="POST" action="{{ route('admin.districts.store') }}">
    @csrf

    <label>District Name</label>
    <input type="text" name="name" required style="padding:10px; width:300px;">

    <br><br>

    <button class="btn-green">Save District</button>
</form>

@endsection