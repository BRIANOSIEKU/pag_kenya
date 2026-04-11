@extends('layouts.district_admin')

@section('content')

<h2>Edit Assembly Member</h2>

<form method="POST"
      action="{{ route('district.assemblies.members.update', [$assembly->id, $member->id]) }}">

    @csrf
    @method('PUT')

    <!-- NAME -->
    <label>Name</label><br>
    <input type="text" name="name" value="{{ $member->name }}" required><br><br>

    <!-- GENDER -->
    <label>Gender</label><br>
    <select name="gender" required>
        <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
    </select><br><br>

    <!-- CONTACT -->
    <label>Contact</label><br>
    <input type="text" name="contact" value="{{ $member->contact }}" required><br><br>

    <!-- SUBMIT -->
    <button type="submit"
            style="background:#FFC107;color:#fff;padding:8px 12px;border:none;">
        Update Member
    </button>

</form>

@endsection