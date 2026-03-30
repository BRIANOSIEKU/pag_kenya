@extends('layouts.admin')

@section('content')

<h2>Edit Partner</h2>

<form action="{{ route('admin.partners.update', $partner) }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <label>Name</label><br>
    <input type="text" name="name" 
           value="{{ $partner->name }}" 
           required style="width:100%;padding:8px;"><br><br>

    <label>Current Logo</label><br>
    @if($partner->logo)
        <img src="{{ asset('storage/'.$partner->logo) }}" width="150"><br><br>
    @endif

    <label>Change Logo</label><br>
    <input type="file" name="logo"><br><br>

    <label>Description</label><br>
    <textarea name="description" rows="5"
        style="width:100%;padding:8px;">{{ $partner->description }}</textarea><br><br>

    <button type="submit"
        style="background:#FF9800;color:white;padding:10px 20px;border:none;border-radius:6px;">
        Update Partner
    </button>

</form>

@endsection
