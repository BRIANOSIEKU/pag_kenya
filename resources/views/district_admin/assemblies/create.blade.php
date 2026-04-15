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
    margin-bottom: 5px;
}

/* ===== INPUTS ===== */
input[type="text"] {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 15px;
}

/* ===== BUTTON ===== */
button {
    padding: 12px 15px;
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
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

    <h2>Create Assembly</h2>

    <div class="form-card">

        <form method="POST" action="{{ route('district.admin.assemblies.store') }}">
            @csrf

            <!-- NAME -->
            <label>Assembly Name</label>
            <input type="text" name="name" required>

            <!-- ADDRESS -->
            <label>Physical Address</label>
            <input type="text" name="physical_address" required>

            <!-- SUBMIT -->
            <button type="submit">
                Submit (Pending Approval)
            </button>

        </form>

    </div>

</div>

@endsection