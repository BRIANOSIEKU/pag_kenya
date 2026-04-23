@extends('layouts.admin')

@section('content')

<h2>Add Other Department Leader</h2>

<form action="{{ route('admin.departments.other-leaders.store', $department->id) }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf

    {{-- hidden department --}}
    <input type="hidden" name="department_id" value="{{ $department->id }}">

    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Position</label><br>
    <input type="text" name="position" required><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone"><br><br>

    <label>Email</label><br>
    <input type="email" name="email"><br><br>

    <label>Photo</label><br>
    <input type="file" name="photo"><br><br>

    <button type="submit">Save Leader</button>
</form>

@endsection