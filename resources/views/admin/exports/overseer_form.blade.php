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
    background: linear-gradient(135deg, #1e3c72, #2a5298);
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
    border-left: 4px solid #1e3c72;
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
    border-color: #1e3c72;
    box-shadow: 0 0 5px rgba(30,60,114,0.25);
}

/* BUTTON */
.btn-submit {
    width: 100%;
    padding: 12px;
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: #3e9441;
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
        <h2>Overseer Reimbursement Export</h2>
        <p>Generate PDF showing 15% overseer allowance per district report</p>
    </div>

    <div class="export-body">

        <!-- INFO -->
        <div class="info-box">
            📌 This report calculates <strong>15% of total approved tithe</strong> and generates a bank-ready reimbursement PDF.
        </div>

        <form method="POST" action="{{ route('admin.export.overseer.generate') }}">
            @csrf

            <!-- YEAR -->
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" required class="form-control"
                       value="{{ old('year') }}"
                       placeholder="e.g 2026">
            </div>

            <!-- MONTH -->
            <div class="form-group">
                <label>Month</label>
                <select name="month" required class="form-control">
                    @foreach([
                        'January','February','March','April','May','June',
                        'July','August','September','October','November','December'
                    ] as $month)
                        <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
                <div class="helper-text">Must match how month is stored in database</div>
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label>Status</label>
                <select name="status" required class="form-control">
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                </select>
                <div class="helper-text">Filter reports by approval status</div>
            </div>

            <!-- BANK -->
            <div class="form-group">
                <label>Bank (Optional)</label>
                <select name="bank" class="form-control">
                    <option value="">-- All Banks --</option>

                    @forelse($banks as $bank)
                        <option value="{{ $bank }}" {{ old('bank') == $bank ? 'selected' : '' }}>
                            {{ $bank }}
                        </option>
                    @empty
                        <option disabled>No banks available</option>
                    @endforelse

                </select>
                <div class="helper-text">Leave empty to include all banks</div>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn-submit">
                Generate PDF Report
            </button>

        </form>

    </div>

</div>

@endsection