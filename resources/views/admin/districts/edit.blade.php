@extends('layouts.admin')

@section('content')

<h2>Edit District</h2>

<form method="POST" action="{{ route('admin.districts.update', $district->id) }}">
    @csrf
    @method('PUT')

    <label>District Name</label>
    <input type="text" name="name" value="{{ $district->name }}" required
           style="padding:10px; width:300px;">

    <br><br>

    <button class="btn-green">Update District</button>
</form>

@endsection