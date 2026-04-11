@extends('layouts.district_admin')

@section('content')

<h2>Edit Assembly Leader</h2>

<form method="POST"
      action="{{ route('district.assemblies.leaders.update', [$assembly->id, $leader->id]) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <!-- NAME -->
    <label>Name</label><br>
    <input type="text" name="name" value="{{ $leader->name }}" required><br><br>

    <!-- POSITION -->
    <label>Position</label><br>
    <select name="position" required>
        @php
            $positions = [
                'Secretary',
                'Treasurer',
                'CEYD',
                'Deacon',
                'Deaconess',
                'Women Director',
                'Sunday School Superintendent'
            ];
        @endphp

        @foreach($positions as $pos)
            <option value="{{ $pos }}"
                {{ $leader->position == $pos ? 'selected' : '' }}>
                {{ $pos }}
            </option>
        @endforeach
    </select><br><br>

    <!-- GENDER -->
    <label>Gender</label><br>
    <select name="gender" required>
        <option value="Male" {{ $leader->gender == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ $leader->gender == 'Female' ? 'selected' : '' }}>Female</option>
    </select><br><br>

    <!-- CONTACT -->
    <label>Contact</label><br>
    <input type="text" name="contact" value="{{ $leader->contact }}"><br><br>

    <!-- NATIONAL ID -->
    <label>National ID</label><br>
    <input type="text" name="national_id" value="{{ $leader->national_id }}"><br><br>

    <!-- DOB -->
    <label>Date of Birth</label><br>
    <input type="date" name="dob" value="{{ $leader->dob }}"><br><br>

    <!-- CURRENT PHOTO -->
    <label>Current Photo</label><br>
    @if($leader->photo)
        <img src="{{ asset('storage/'.$leader->photo) }}" width="80"><br><br>
    @endif

    <!-- NEW PHOTO -->
    <input type="file" name="photo"><br><br>

    <!-- ATTACHMENTS -->
    <label>New Attachments</label><br>
    <input type="file" name="attachments[]" multiple><br><br>

    <!-- EXISTING ATTACHMENTS -->
    @php
        $attachments = $leader->attachments ? json_decode($leader->attachments, true) : [];
    @endphp

    @if(!empty($attachments))
        <p>Existing Attachments:</p>
        @foreach($attachments as $file)
            <a href="{{ asset('storage/'.$file) }}" target="_blank">
                {{ basename($file) }}
            </a><br>
        @endforeach
        <br>
    @endif

    <button type="submit"
            style="background:#FFC107;color:#fff;padding:8px 12px;border:none;">
        Update Leader
    </button>

</form>

@endsection