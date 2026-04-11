@extends('layouts.district_admin')

@section('content')

<h2>Edit Pastoral Member</h2>

<form action="{{ route('district.admin.pastoral.update', $pastor->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <!-- NAME -->
    <label>Name</label><br>
    <input type="text" name="name" value="{{ old('name', $pastor->name) }}" required><br><br>

    <!-- NATIONAL ID -->
    <label>National ID</label><br>
    <input type="text" name="national_id" value="{{ old('national_id', $pastor->national_id) }}" required><br><br>

    <!-- GENDER -->
    <label>Gender</label><br>
    <select name="gender" required>
        <option value="Male" {{ old('gender', $pastor->gender) == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ old('gender', $pastor->gender) == 'Female' ? 'selected' : '' }}>Female</option>
    </select><br><br>

    <!-- CONTACT -->
    <label>Contact</label><br>
    <input type="text" name="contact" value="{{ old('contact', $pastor->contact) }}" required><br><br>

    <!-- ASSEMBLY (IMPORTANT FIX) -->
    <label>Assembly</label><br>
    <select name="assembly_id" required>
        <option value="">-- Select Assembly --</option>

        @foreach($assemblies as $assembly)
            <option value="{{ $assembly->id }}"
                {{ old('assembly_id', $pastor->assembly_id) == $assembly->id ? 'selected' : '' }}>
                {{ $assembly->name }}
            </option>
        @endforeach
    </select><br><br>

    <!-- GRADUATION YEAR -->
    <label>Graduation Year</label><br>
    <input type="number" name="graduation_year"
           value="{{ old('graduation_year', $pastor->graduation_year) }}"><br><br>

    <!-- DATE OF BIRTH -->
    <label>Date of Birth</label><br>
    <input type="date" name="date_of_birth"
           value="{{ old('date_of_birth', $pastor->date_of_birth) }}"><br><br>

    <!-- CURRENT PHOTO -->
    <label>Current Photo</label><br>
    @if($pastor->photo)
        <img src="{{ asset('storage/'.$pastor->photo) }}"
             width="80"
             style="border-radius:8px;"><br><br>
    @else
        <p>No photo uploaded</p>
    @endif

    <!-- CHANGE PHOTO -->
    <label>Change Photo</label><br>
    <input type="file" name="photo"><br><br>

    <!-- ATTACHMENTS (EXISTING) -->
    <label>Existing Attachments</label><br>
    @php
        $files = json_decode($pastor->attachments, true) ?? [];
    @endphp

    @if(count($files))
        <ul>
            @foreach($files as $file)
                <li>
                    <a href="{{ asset('storage/'.$file) }}" target="_blank">
                        View File
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No attachments</p>
    @endif

    <br>

    <!-- NEW ATTACHMENTS -->
    <label>Add More Attachments</label><br>
    <input type="file" name="attachments[]" multiple><br><br>

    <button type="submit" style="background:blue;color:#fff;padding:8px 12px;">
        Update
    </button>

</form>

@endsection