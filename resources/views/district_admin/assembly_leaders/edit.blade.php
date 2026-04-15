@extends('layouts.district_admin')

@section('content')

<style>
/* ===== GLOBAL SAFETY FIX ===== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    padding: 15px;
    max-width: 100%;
}

/* ===== FORM CARD ===== */
.form-card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== TITLE ===== */
h2 {
    color: #1e3c72;
    margin-bottom: 15px;
}

/* ===== LABELS ===== */
label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
}

/* ===== INPUTS ===== */
input[type="text"],
input[type="date"],
select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

/* ===== IMAGE ===== */
img {
    border-radius: 6px;
    max-width: 100%;
    height: auto;
}

/* ===== LINKS ===== */
a {
    color: #2196F3;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 5px;
    word-break: break-word;
}

/* ===== BUTTON ===== */
button {
    background: #FFC107;
    color: #fff;
    padding: 12px 15px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    margin-top: 15px;
}

/* ===== SECTION SPACING ===== */
.section {
    margin-bottom: 15px;
}

/* ===== MOBILE ===== */
@media (max-width: 480px) {
    .page-wrapper {
        padding: 10px;
    }

    button {
        font-size: 16px;
    }
}
</style>

<div class="page-wrapper">

    <h2>Edit Assembly Leader</h2>

    <div class="form-card">

        <form method="POST"
              action="{{ route('district.assemblies.leaders.update', [$assembly->id, $leader->id]) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- NAME -->
            <label>Name</label>
            <input type="text" name="name" value="{{ $leader->name }}" required>

            <!-- POSITION -->
            <label>Position</label>
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
            </select>

            <!-- GENDER -->
            <label>Gender</label>
            <select name="gender" required>
                <option value="Male" {{ $leader->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $leader->gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <!-- CONTACT -->
            <label>Contact</label>
            <input type="text" name="contact" value="{{ $leader->contact }}">

            <!-- NATIONAL ID -->
            <label>National ID</label>
            <input type="text" name="national_id" value="{{ $leader->national_id }}">

            <!-- DOB -->
            <label>Date of Birth</label>
            <input type="date" name="dob" value="{{ $leader->dob }}">

            <!-- CURRENT PHOTO -->
            <label>Current Photo</label>
            @if($leader->photo)
                <img src="{{ asset('storage/'.$leader->photo) }}" width="80">
            @endif

            <!-- NEW PHOTO -->
            <label>Change Photo</label>
            <input type="file" name="photo">

            <!-- ATTACHMENTS -->
            <label>New Attachments</label>
            <input type="file" name="attachments[]" multiple>

            <!-- EXISTING ATTACHMENTS -->
            @php
                $attachments = $leader->attachments ? json_decode($leader->attachments, true) : [];
            @endphp

            @if(!empty($attachments))
                <div class="section">
                    <strong>Existing Attachments:</strong><br>

                    @foreach($attachments as $file)
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">
                            {{ basename($file) }}
                        </a><br>
                    @endforeach
                </div>
            @endif

            <!-- SUBMIT -->
            <button type="submit">
                Update Leader
            </button>

        </form>

    </div>

</div>

@endsection