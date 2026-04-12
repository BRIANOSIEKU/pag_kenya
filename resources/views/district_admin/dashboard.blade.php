@extends('layouts.district_admin')

@section('content')

<style>
/* ===== GRID CONTROL ===== */
.dashboard-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

/* ===== CARD ===== */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    color: #1e3c72;
    margin-bottom: 10px;
    font-size: 1.3rem;
}

.card p {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.card a {
    display: inline-block;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
}

/* BUTTON COLORS */
.btn-green { background: #4CAF50; }
.btn-blue { background: #2196F3; }
.btn-orange { background: #FF9800; }
.btn-purple { background: #9C27B0; }
.btn-red { background: #FF5722; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .dashboard-row {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- ===== USER INFO ===== -->
<p>Welcome, <strong>{{ session('district_admin_username') }}</strong></p>
<p><strong>District:</strong> {{ $district->name ?? 'N/A' }}</p>

<hr>

<!-- ================= ROW 1 ================= -->
<div class="dashboard-row">

    <!-- Assemblies Management -->
    <div class="card">
        <h3>Assemblies Management</h3>
        <p>
            Register Assemblies and manage Members & Leaders database including
            roles, contacts, and membership records.
        </p>

        <a href="{{ route('district.admin.assemblies.index') }}" class="btn-green">
            Manage Assemblies
        </a>
    </div>

    <!-- Pastoral Team -->
    <div class="card">
        <h3>Pastoral Team</h3>
        <p>
            Register pastors, upload documents, and manage pastoral records.
        </p>

        <a href="{{ route('district.admin.pastoral.index') }}" class="btn-orange">
            Manage Pastoral Team
        </a>
    </div>

</div>

<!-- ================= ROW 2 ================= -->
<div class="dashboard-row">

    <!-- Tithe Reports -->
    <div class="card">
        <h3>Tithe Reports</h3>
        <p>
            Submit monthly tithe reports, upload Mukhtasari,
            and track approval status.
        </p>

        <a href="{{ route('district.admin.tithes.index') }}" class="btn-purple">
            View Reports
        </a>
    </div>

    <!-- Pastoral Transfers -->
    <div class="card">
        <h3>Pastoral Transfers</h3>
        <p>
            Initiate transfers within or across districts and track approvals.
        </p>

        <a href="{{ route('district.admin.pastoral.transfers.index') }}" class="btn-red">
            Manage Transfers
        </a>
    </div>

    <!-- Downloads -->
    <div class="card">
        <h3>Downloads</h3>
        <p>
            Access official documents, circulars, reports, and attachments uploaded by the District Office.
        </p>

        <a href="{{ route('district.admin.downloads.index') }}" class="btn-blue">
            View Downloads
        </a>
    </div>

</div>

@endsection