@extends('layouts.admin')

@section('content')

<style>
.export-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.export-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: 0.2s;
}

.export-card:hover {
    transform: translateY(-4px);
}

.export-card h3 {
    color: #1e3c72;
    margin-bottom: 10px;
}

.export-card p {
    font-size: 0.9rem;
    color: #555;
}

.export-card a {
    display: block;
    margin-top: 10px;
    padding: 10px;
    text-align: center;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

.btn-green { background: #4CAF50; }
.btn-blue { background: #2196F3; }
.btn-orange { background: #FF9800; }
.btn-purple { background: #9C27B0; }
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

   <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
            ← Back to District Module Dashboard
        </a>


<h2>Export Center</h2>

<div class="export-grid">

    <!-- ================= Overseer Reimbursement ================= -->
    <div class="export-card">
        <h3>Overseer Reimbursement</h3>
        <p>Generate 15% reimbursement report for overseers</p>
        <a href="{{ route('admin.export.overseer.form') }}" class="btn-green">
            Generate Report
        </a>
    </div>

    <!-- ================= Placeholder for next exports ================= -->
    <div class="export-card">
        <h3>District Summary</h3>
        <p>Generate district summary report</p>
        <a href="{{ route('admin.export.district_summary.form') }}" class="btn-blue">Generate Report</a>
    </div>

<div class="export-card">
    <h3>Executive Office Allocation</h3>
    <p>Generate executive office allocation report</p>
    <a href="{{ route('admin.export.national.form') }}" class="btn-purple">
        Generate Report
    </a>
</div>

</div>

@endsection