@extends('layouts.admin')

@section('content')

<style>
.export-wrapper {
    max-width: 650px;
    margin: 40px auto;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    overflow: hidden;
    font-family: Arial, sans-serif;
}

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

.export-body {
    padding: 25px;
}

.info-box {
    background: #f4f6f9;
    border-left: 4px solid #1e3c72;
    padding: 10px 12px;
    margin-bottom: 20px;
    font-size: 13px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background: #2196F3;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

.btn-submit:hover {
    background: #1976d2;
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

    <div class="export-header">
        <h2>District Summary Export</h2>
        <p>Generate ranked assembly tithe report per district</p>
    </div>

    <div class="export-body">

        <div class="info-box">
            📌 This report ranks all assemblies by tithe contribution and shows overseer details.
        </div>

        <form method="POST" action="{{ route('admin.export.district_summary.generate') }}">
            @csrf

            <!-- DISTRICT -->
            <div class="form-group">
                <label>District</label>
                <select name="district_id" class="form-control" required>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- YEAR -->
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" class="form-control" required>
            </div>

            <!-- MONTH -->
            <div class="form-group">
                <label>Month</label>
                <select name="month" class="form-control" required>
                    @foreach([
                        'January','February','March','April','May','June',
                        'July','August','September','October','November','December'
                    ] as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">
                Generate PDF Report
            </button>

        </form>

    </div>
</div>

@endsection