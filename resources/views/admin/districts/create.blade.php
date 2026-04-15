@extends('layouts.admin')

@section('content')

<h2 class="page-title">Create District</h2>

<style>
/* ===== PAGE TITLE ===== */
.page-title {
    font-size: 22px;
    margin-bottom: 20px;
}

/* ===== FORM CONTAINER ===== */
.form-card {
    max-width: 500px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== LABEL ===== */
.form-card label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 14px;
}

/* ===== INPUT ===== */
.form-card input[type="text"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    outline: none;
}

.form-card input[type="text"]:focus {
    border-color: #4CAF50;
}

/* ===== BUTTON ===== */
.btn-green {
    display: inline-block;
    margin-top: 15px;
    padding: 12px 16px;
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    width: 100%;
}

.btn-green:hover {
    opacity: 0.9;
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-card {
        padding: 15px;
    }

    .page-title {
        font-size: 18px;
    }
}
</style>

<div class="form-card">

    <form method="POST" action="{{ route('admin.districts.store') }}">
        @csrf

        <label>District Name</label>
        <input type="text" name="name" placeholder="Enter district name" required>

        <button type="submit" class="btn-green">
            Save District
        </button>
    </form>

</div>

@endsection