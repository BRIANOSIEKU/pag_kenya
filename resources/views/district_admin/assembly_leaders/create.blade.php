@extends('layouts.district_admin')

@section('content')

<h2>Add Assembly Leader - {{ $assembly->name }}</h2>

<form method="POST"
      action="{{ route('district.assemblies.leaders.store', $assembly->id) }}"
      enctype="multipart/form-data">

    @csrf

    <!-- NAME -->
    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <!-- POSITION (ENUM) -->
    <label>Position</label><br>
    <select name="position" required>
        <option value="">-- Select Position --</option>
        <option value="Secretary">Secretary</option>
        <option value="Treasurer">Treasurer</option>
        <option value="CEYD">CEYD</option>
        <option value="Deacon">Deacon</option>
        <option value="Deaconess">Deaconess</option>
        <option value="Women Director">Women Director</option>
        <option value="Sunday School Superintendent">Sunday School Superintendent</option>
    </select><br><br>

    <!-- GENDER -->
    <label>Gender</label><br>
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br><br>

    <!-- CONTACT -->
    <label>Contact</label><br>
    <input type="text" name="contact" required><br><br>

    <!-- NATIONAL ID -->
    <label>National ID</label><br>
    <input type="text" name="national_id" required><br><br>

    <!-- DOB -->
    <label>Date of Birth</label><br>
    <input type="date" name="dob" required><br><br>

    <!-- PHOTO -->
    <label>Photo</label><br>
    <input type="file" name="photo"><br><br>

    <!-- ATTACHMENTS -->
    <label>Attachments</label><br>
    <input type="file" name="attachments[]" multiple><br><br>

    <!-- SUBMIT -->
    <button type="submit"
            style="background:#4CAF50;color:#fff;padding:8px 12px;border:none;">
        Save Leader
    </button>

</form>

@endsection