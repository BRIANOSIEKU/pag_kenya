@extends('layouts.district_admin')

@section('content')

<h2>Add Pastoral Team Member</h2>

@if ($errors->any())
<div style="margin:10px 0; padding:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('district.admin.pastoral.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <label>Name</label><br>
    <input type="text" name="name" style="width:100%;padding:8px;"><br><br>

    <label>National ID</label><br>
    <input type="text" name="national_id" style="width:100%;padding:8px;"><br><br>

    <label>Assembly</label><br>
    <select name="assembly_id" style="width:100%;padding:8px;" required>
        <option value="">-- Select Assembly --</option>
        @foreach($assemblies as $assembly)
            <option value="{{ $assembly->id }}">{{ $assembly->name }}</option>
        @endforeach
    </select><br><br>

    <label>Contact</label><br>
    <input type="text" name="contact" style="width:100%;padding:8px;"><br><br>

    <label>Gender</label><br>
    <select name="gender" style="width:100%;padding:8px;">
        <option>Male</option>
        <option>Female</option>
    </select><br><br>

    <label>Graduation Year</label><br>
    <input type="number" name="graduation_year" style="width:100%;padding:8px;"><br><br>

    <label>Date of Birth</label><br>
    <input type="date" name="date_of_birth" style="width:100%;padding:8px;"><br><br>

    <label>Photo</label><br>
    <input type="file" name="photo"><br><br>

    <label>Attachments</label><br>
    <input type="file" name="attachments[]" multiple><br><br>

    <button type="submit"
            style="background:#4CAF50;color:#fff;padding:10px 15px;border:none;border-radius:6px;">
        Save Pastor
    </button>

</form>

@endsection