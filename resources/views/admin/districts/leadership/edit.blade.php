@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
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

/* ===== IMAGE ===== */
.current-photo {
    width: 90px;
    height: 90px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #ddd;
}

/* ===== FILE INPUTS ===== */
input[type="file"] {
    margin-top: 5px;
}

/* ===== ATTACHMENTS ===== */
.attachments a {
    display: inline-block;
    margin-bottom: 6px;
    color: #2196F3;
    text-decoration: none;
    font-size: 13px;
}

.attachments a:hover {
    text-decoration: underline;
}

/* ===== BUTTON ===== */
.btn-update {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    background: #FFC107;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
}

.btn-update:hover {
    opacity: 0.9;
}

/* ===== GRID FOR BANK DETAILS (optional clean look) ===== */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
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

        <h2 class="page-title">Edit Leader</h2>

        <form method="POST"
              action="{{ route('admin.districts.leadership.update', [$district->id, $leader->id]) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- NAME -->
            <label>Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $leader->name) }}"
                   required>

            <!-- POSITION -->
            <label>Position</label>
            <select name="position" required>
                <option value="">-- Select Position --</option>

                @foreach([
                    'Overseer','Secretary','CEYD','Women Director',
                    'LayPerson','Treasurer','Senior Pastor'
                ] as $pos)
                    <option value="{{ $pos }}"
                        {{ old('position', $leader->position) == $pos ? 'selected' : '' }}>
                        {{ $pos }}
                    </option>
                @endforeach
            </select>

            <!-- GENDER -->
            <label>Gender</label>
            <select name="gender" required>
                <option value="Male" {{ old('gender', $leader->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $leader->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <!-- CONTACT -->
            <label>Contact</label>
            <input type="text" name="contact" value="{{ old('contact', $leader->contact) }}">

            <!-- NATIONAL ID -->
            <label>National ID</label>
            <input type="text" name="national_id" value="{{ old('national_id', $leader->national_id) }}">

            <!-- DATE OF BIRTH -->
            <label>Date of Birth</label>
            <input type="date"
                   name="dob"
                   value="{{ old('dob', \Carbon\Carbon::parse($leader->dob)->format('Y-m-d')) }}">

            <!-- BANK DETAILS -->
            <h3 class="section-title">Bank Details</h3>

            <div class="grid-2">

                <div>
                    <label>Bank Name</label>
                    <input type="text" name="bank_name"
                           value="{{ old('bank_name', $leader->bank_name) }}" required>
                </div>

                <div>
                    <label>Branch</label>
                    <input type="text" name="bank_branch"
                           value="{{ old('bank_branch', $leader->bank_branch) }}" required>
                </div>

            </div>

            <label>Account Number</label>
            <input type="text" name="account_number"
                   value="{{ old('account_number', $leader->account_number) }}" required>

            <!-- CURRENT PHOTO -->
            <label>Current Photo</label>

            @if($leader->photo)
                <br>
                <img src="{{ asset('storage/'.$leader->photo) }}" class="current-photo">
            @else
                <p>No photo available</p>
            @endif

            <!-- NEW PHOTO -->
            <label>Update Photo</label>
            <input type="file" name="photo">

            <!-- NEW ATTACHMENTS -->
            <label>New Attachments</label>
            <input type="file" name="attachments[]" multiple>

            <!-- EXISTING ATTACHMENTS -->
            @if($leader->attachments)
                <label class="section-title">Existing Attachments</label>

                <div class="attachments">
                    @foreach($leader->attachments as $file)
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">
                            📎 View File
                        </a><br>
                    @endforeach
                </div>
            @endif

            <!-- SUBMIT -->
            <button type="submit" class="btn-update">
                Update Leader
            </button>

        </form>

    </div>

</div>

@endsection