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

/* ===== BUTTON ===== */
button {
    background: #4CAF50;
    color: #fff;
    padding: 12px 15px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    margin-top: 15px;
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

    <h2>Add Assembly Leader - {{ $assembly->name }}</h2>

    <div class="form-card">

        <form method="POST"
              action="{{ route('district.assemblies.leaders.store', $assembly->id) }}"
              enctype="multipart/form-data">

            @csrf

            <!-- NAME -->
            <label>Name</label>
            <input type="text" name="name" required>

            <!-- POSITION -->
            <label>Position</label>
            <select name="position" required>
                <option value="">-- Select Position --</option>
                <option value="Secretary">Secretary</option>
                <option value="Treasurer">Treasurer</option>
                <option value="CEYD">CEYD</option>
                <option value="Deacon">Deacon</option>
                <option value="Deaconess">Deaconess</option>
                <option value="Women Director">Women Director</option>
                <option value="Sunday School Superintendent">Sunday School Superintendent</option>
            </select>

            <!-- GENDER -->
            <label>Gender</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <!-- CONTACT -->
            <label>Contact</label>
            <input type="text" name="contact" required>

            <!-- NATIONAL ID -->
            <label>National ID</label>
            <input type="text" name="national_id" required>

            <!-- DOB -->
            <label>Date of Birth</label>
            <input type="date" name="dob" required>

            <!-- PHOTO -->
            <label>Photo</label>
            <input type="file" name="photo">

            <!-- ATTACHMENTS -->
            <label>Attachments</label>
            <input type="file" name="attachments[]" multiple>

            <!-- SUBMIT -->
            <button type="submit">
                Save Leader
            </button>

        </form>

    </div>

</div>

@endsection