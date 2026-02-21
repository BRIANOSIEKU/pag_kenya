@extends('layouts.admin')

@section('content')

<h2>Add Partner</h2>

<form action="{{ route('admin.partners.store') }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf

    <label>Name</label><br>
    <input type="text" name="name" required style="width:100%;padding:8px;"><br><br>

    <label>Logo</label><br>
    <input type="file" name="logo"><br><br>

    <label>Description</label><br>
    <textarea name="description" rows="5" style="width:100%;padding:8px;"></textarea><br><br>

    <button type="submit"
        style="background:#2196F3;color:white;padding:10px 20px;border:none;border-radius:6px;">
        Save Partner
    </button>

</form>

@endsection
