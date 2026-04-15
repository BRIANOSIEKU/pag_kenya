@extends('layouts.admin')

@section('content')

<style>
/* ===== CONTAINER ===== */
.form-container {
    max-width: 800px;
    margin: auto;
    padding: 10px;
}

/* ===== CARD ===== */
.form-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== TITLE ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 15px;
}

/* ===== LABEL ===== */
label {
    display: block;
    margin-top: 12px;
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 14px;
}

/* ===== INPUTS ===== */
input[type="text"],
input[type="date"],
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    outline: none;
}

input:focus, select:focus {
    border-color: #2196F3;
}

/* ===== SECTION TITLE ===== */
.section-title {
    margin-top: 20px;
    margin-bottom: 10px;
    font-size: 18px;
}

/* ===== GRID ===== */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

/* ===== FILE INPUTS ===== */
input[type="file"] {
    margin-top: 5px;
}

/* ===== BUTTON ===== */
.btn-save {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
}

.btn-save:hover {
    opacity: 0.9;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }

    .page-title {
        font-size: 18px;
    }
}
</style>

<div class="form-container">

    <div class="form-card">

        <h2 class="page-title">
            Add District Leader - {{ $district->name }}
        </h2>

        <form method="POST"
              action="{{ route('admin.districts.leadership.store', $district->id) }}"
              enctype="multipart/form-data">

            @csrf

            <!-- NAME -->
            <label>Name</label>
            <input type="text" name="name" required placeholder="Enter full name">

            <!-- POSITION -->
            <label>Position</label>
            <select name="position" required>
                <option value="">-- Select Position --</option>
                <option value="Overseer">Overseer</option>
                <option value="Secretary">Secretary</option>
                <option value="CEYD">CEYD</option>
                <option value="Women Director">Women Director</option>
                <option value="LayPerson">LayPerson</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Senior Pastor">Senior Pastor</option>
            </select>

            <!-- GENDER -->
            <label>Gender</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <!-- CONTACT -->
            <label>Contact</label>
            <input type="text" name="contact" required placeholder="Enter phone number">

            <!-- NATIONAL ID -->
            <label>National ID</label>
            <input type="text" name="national_id" required>

            <!-- DOB -->
            <label>Date of Birth</label>
            <input type="date" name="dob" required>

            <!-- BANK DETAILS -->
            <h3 class="section-title">Bank Details</h3>

            <div class="grid-2">

                <div>
                    <label>Bank Name</label>
                    <input type="text" name="bank_name" required>
                </div>

                <div>
                    <label>Branch</label>
                    <input type="text" name="bank_branch" required>
                </div>

            </div>

            <label>Account Number</label>
            <input type="text" name="account_number" required>

            <!-- UPLOADS -->
            <h3 class="section-title">Uploads</h3>

            <label>Photo</label>
            <input type="file" name="photo">

            <label>Attachments (Certificates, ID, etc)</label>
            <input type="file" name="attachments[]" multiple>

            <!-- SUBMIT -->
            <button type="submit" class="btn-save">
                Save Leader
            </button>

        </form>

    </div>

</div>

@endsection