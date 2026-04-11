@extends('layouts.admin')

@section('content')

<h2>Add District Leader - {{ $district->name }}</h2>

<form method="POST"
      action="{{ route('admin.districts.leadership.store', $district->id) }}"
      enctype="multipart/form-data">

@csrf

<label>Name</label><br>
<input type="text" name="name" required><br><br>

<label>Position</label><br>
<select name="position" required>
    <option value="">-- Select Position --</option>
    <option value="Overseer">Overseer</option>
    <option value="Secretary">Secretary</option>
    <option value="CEYD">CEYD</option>
    <option value="Women Director">Women Director</option>
    <option value="LayPerson">LayPerson</option>
    <option value="Treasurer">Treasurer</option>
    <option value="Senior Pastor">Senior Pastor</option>
</select><br><br>

<label>Gender</label><br>
<select name="gender" required>
    <option>Male</option>
    <option>Female</option>
</select><br><br>

<label>Contact</label><br>
<input type="text" name="contact" required><br><br>

<label>National ID</label><br>
<input type="text" name="national_id" required><br><br>

<label>Date of Birth</label><br>
<input type="date" name="dob" required><br><br>

<label>Photo</label><br>
<input type="file" name="photo"><br><br>

<label>Attachments (Certificates, ID, etc)</label><br>
<input type="file" name="attachments[]" multiple><br><br>

<button type="submit" style="background:#4CAF50; color:#fff; padding:8px 12px; border:none;">
    Save Leader
</button>

</form>

@endsection