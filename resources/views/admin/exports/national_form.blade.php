@extends('layouts.admin')

@section('content')

<style>
.export-wrapper {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    overflow: hidden;
    font-family: Arial, sans-serif;
}

/* HEADER */
.export-header {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    padding: 20px;
}

.export-header h2 {
    margin: 0;
    font-size: 18px;
}

.export-header p {
    margin: 5px 0 0;
    font-size: 13px;
    opacity: 0.9;
}

/* BODY */
.export-body {
    padding: 25px;
}

/* INFO BOX */
.info-box {
    background: #f4f6f9;
    border-left: 4px solid #6a11cb;
    padding: 10px 12px;
    margin-bottom: 20px;
    font-size: 13px;
    color: #444;
    border-radius: 6px;
}

/* FORM */
.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.2s;
}

.form-control:focus {
    border-color: #6a11cb;
    box-shadow: 0 0 5px rgba(106,17,203,0.25);
}

/* BUTTON */
.btn-submit {
    width: 100%;
    padding: 12px;
    background: #6a11cb;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: #4b0ea3;
}

/* HELPER */
.helper-text {
    font-size: 12px;
    color: #777;
    margin-top: 4px;
}
</style>

<style>
    .btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}

.btn-back:hover {
    opacity: 0.85;
}
</style>

   <a href="{{ route('admin.exports.index') }}" class="btn-back">
            ← Back to Exports Dashboard
        </a>


<div class="export-wrapper">

    <!-- HEADER -->
    <div class="export-header">
        <h2>Executive Office Tithe Export</h2>
        <p>Generate executive office allocation report (after 15% overseer deduction)</p>
    </div>

    <div class="export-body">

        <!-- INFO -->
        <div class="info-box">
            📌 This report calculates:
            <strong>Total Tithe → 15% Overseer Share → Remaining National Office Share</strong>
        </div>

        <form method="POST" action="{{ route('admin.export.national.generate') }}">
            @csrf

            <!-- YEAR -->
            <div class="form-group">
                <label>Year</label>
                <input type="number"
                       name="year"
                       class="form-control"
                       required
                       value="{{ old('year') }}"
                       placeholder="e.g 2026">
            </div>

            <!-- MONTH -->
            <div class="form-group">
                <label>Month</label>
                <select name="month" class="form-control" required>
                    @foreach([
                        'January','February','March','April','May','June',
                        'July','August','September','October','November','December'
                    ] as $month)
                        <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
                <div class="helper-text">Select reporting month</div>
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>
                </select>
                <div class="helper-text">Only approved reports are included</div>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn-submit">
                Generate PDF Report
            </button>

        </form>

    </div>

</div>

@endsection