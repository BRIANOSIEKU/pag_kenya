@extends('layouts.admin')

@section('content')

<!-- ================= DISTRICT MANAGEMENT ================= -->

<style>
/* Ensure district section matches dashboard styling */

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-4px);
}

.card h3 {
    margin-bottom: 10px;
    font-size: 1.2rem;
    color: #1e3c72;
}

.card p {
    margin-bottom: 12px;
    font-size: 0.95rem;
    color: #555;
}

.card a {
    display: inline-block;
    padding: 10px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    color: #fff;
    transition: 0.3s ease;
}

.card a:hover {
    opacity: 0.85;
}

/* Buttons */
.btn-gold { background: #FFD700; color: #1e3c72; }
.btn-green { background: #4CAF50; }
.btn-blue { background: #2196F3; }
.btn-orange { background: #FF9800; }
.btn-purple { background: #9C27B0; }

h2 {
    margin-top: 40px;
    margin-bottom: 20px;
    color: #1e3c72;
    font-size: 1.5rem;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 6px;
}
</style>

<h2>District Management</h2>

<div class="dashboard-grid">

    <div class="card">
        <h3>Districts</h3>
        <p>Create and manage church districts</p>
        <a href="{{ route('admin.districts.index') }}" class="btn-blue">
            Manage Districts
        </a>
    </div>

    <div class="card">
        <h3>District Admins</h3>
        <p>Assign and manage district administrators</p>
        <a href="{{ route('admin.district_admins.index') }}" class="btn-green">
            Manage Admins
        </a>
    </div>

    <div class="card">
        <h3>Tithe Reports</h3>
        <p>View financial tithe reports per district</p>
        <a href="{{ route('admin.tithe_review.index') }}" class="btn-purple">
            View Reports
        </a>
    </div>

    <div class="card">
        <h3>Pastoral Transfers</h3>
        <p>Manage member transfers between districts</p>
        <a href="{{ route('admin.transfers') }}" class="btn-orange">
            View Transfers
        </a>
    </div>

    <div class="card">
        <h3>NEW ASSEMBLY APPROVAL</h3>
        <p>Approve New Assembly Requests</p>
        <a href="{{ route('admin.assembly.requests') }}" class="btn-blue">
            View Requests
        </a>
    </div>

    <!-- ================= NEW DOWNLOADS CARD ================= -->
    <div class="card">
        <h3>Downloads</h3>
        <p>Upload and manage attachments for district admins</p>
        <a href="{{ route('admin.downloads.index') }}" class="btn-gold">
            Manage Downloads
        </a>
    </div>

</div>

@endsection