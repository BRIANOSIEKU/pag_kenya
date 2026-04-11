@extends('layouts.district_admin')

@section('content')

<h2>Add Assembly Member - {{ $assembly->name }}</h2>

<form method="POST"
      action="{{ route('district.assemblies.members.store', $assembly->id) }}">

    @csrf

    <!-- NAME -->
    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <!-- GENDER -->
    <label>Gender</label><br>
    <select name="gender" required>
        <option value="">-- Select Gender --</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br><br>

    <!-- CONTACT -->
    <label>Contact</label><br>
    <input type="text" name="contact" required><br><br>

    <!-- SUBMIT -->
    <button type="submit"
            style="background:#4CAF50;color:#fff;padding:8px 12px;border:none;">
        Save Member
    </button>

</form>

@endsection