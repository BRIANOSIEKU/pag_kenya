@extends('layouts.admin')

@section('content')

@php
use Illuminate\Support\Facades\DB;

// FAST INITIAL LOAD (fallback)
$totalMembers = DB::table('assembly_members')->count();
$totalAssemblies = DB::table('assemblies')->count();
$totalLeaders = DB::table('district_leaders')->count()
                + DB::table('committee_leader')->count();
$totalDistricts = DB::table('districts')->count();
@endphp

<style>
/* ================= STATS ROW ================= */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 25px;
}

/* ================= STAT CARD BASE ================= */
.stats-box {
    padding: 18px 20px;
    border-radius: 14px;
    text-align: center;
    color: #fff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}

.stats-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.18);
}

.stats-title {
    font-size: 13px;
    opacity: 0.9;
    margin-bottom: 6px;
}

.stats-value {
    font-size: 26px;
    font-weight: bold;
}

/* ================= COLORS ================= */

/* GREEN - Members */
.stats-box.green {
    background: linear-gradient(135deg, #43a047, #2e7d32);
}

/* BLUE - Assemblies */
.stats-box.blue {
    background: linear-gradient(135deg, #1e88e5, #1565c0);
}

/* BROWN - Leaders */
.stats-box.brown {
    background: linear-gradient(135deg, #8d6e63, #5d4037);
}

/* PURPLE - Districts */
.stats-box.purple {
    background: linear-gradient(135deg, #8e24aa, #5e35b1);
}

/* shine effect */
.stats-box::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.08);
    transform: rotate(25deg);
}

/* ================= DASHBOARD CARDS ================= */
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
    transition: 0.2s ease;
}

.card:hover {
    transform: translateY(-4px);
}

.card h3 {
    color: #1e3c72;
}

.card p {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 10px;
}

.card a {
    display: block;
    padding: 10px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    color: #fff;
}

/* Buttons */
.btn-gold { background: #FFD700; color:#1e3c72; }
.btn-green { background: #4CAF50; }
.btn-blue { background: #2196F3; }
.btn-orange { background: #FF9800; }
.btn-purple { background: #9C27B0; }

h2 {
    margin-top: 40px;
    margin-bottom: 20px;
    color: #1e3c72;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 6px;
}

/* Responsive */
@media (max-width: 900px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 500px) {
    .stats-row { grid-template-columns: 1fr; }
}
</style>

<!-- ================= LIVE STATS ================= -->
<div class="stats-row">

    <div class="stats-box green">
        <div class="stats-title">Total Members</div>
        <div class="stats-value" id="members">{{ $totalMembers }}</div>
    </div>

    <div class="stats-box blue">
        <div class="stats-title">Total Assemblies</div>
        <div class="stats-value" id="assemblies">{{ $totalAssemblies }}</div>
    </div>

    <div class="stats-box brown">
        <div class="stats-title">Total Leaders</div>
        <div class="stats-value" id="leaders">{{ $totalLeaders }}</div>
    </div>

    <div class="stats-box purple">
        <div class="stats-title">Total Districts</div>
        <div class="stats-value" id="districts">{{ $totalDistricts }}</div>
    </div>

</div>

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

   <a href="{{ route('admin.dashboard') }}" class="btn-back">
            ← Back to Main Dashboard
        </a>

<h2>District Management</h2>

<div class="dashboard-grid">

    <div class="card">
        <h3>Districts</h3>
        <p>Create and manage church districts</p>
        <a href="{{ route('admin.districts.index') }}" class="btn-blue">Manage</a>
    </div>

    <div class="card">
        <h3>District Admins</h3>
        <p>Assign district administrators</p>
        <a href="{{ route('admin.district_admins.index') }}" class="btn-green">Manage</a>
    </div>

    <div class="card">
        <h3>Tithe Reports</h3>
        <p>Review financial reports</p>
        <a href="{{ route('admin.tithe_review.index') }}" class="btn-purple">View</a>
    </div>

    <div class="card">
        <h3>Export Tithe Reports</h3>
        <p>Export financial reports</p>
        <a href="{{ route('admin.exports.index') }}" class="btn-purple">Export</a>
    </div>

    <div class="card">
        <h3>Transfers</h3>
        <p>Manage pastoral transfers</p>
        <a href="{{ route('admin.transfers.index') }}" class="btn-orange">View</a>
    </div>

    <div class="card">
        <h3>Assembly Requests</h3>
        <p>Approve new assemblies</p>
        <a href="{{ route('admin.assembly.requests') }}" class="btn-blue">View</a>
    </div>

    <div class="card">
        <h3>Downloads</h3>
        <p>Manage district files</p>
        <a href="{{ route('admin.downloads.index') }}" class="btn-gold">Open</a>
    </div>
    <div class="card">
        <h3>National Pastoral Approval</h3>
        <p>Approve and review all pastoral teams from districts</p>
        <a href="{{ route('admin.national.pastoral.approvals.index') }}" class="btn-gold">Open</a>
    </div>

        <div class="card">
        <h3>Departments Finance</h3>
        <p>Download Departments Finance Reports</p>
        <a href="{{ route('admin.departments.finance.reports') }}" class="btn-green">Open</a>
    </div>

</div>

<!-- ================= LIVE STATS SCRIPT ================= -->
<script>
function loadStats() {
    fetch("{{ route('admin.dashboard.stats') }}")
        .then(res => res.json())
        .then(res => {

            const data = res.data;

            document.getElementById('members').innerText = data.totalMembers ?? 0;
            document.getElementById('assemblies').innerText = data.totalAssemblies ?? 0;
            document.getElementById('leaders').innerText = data.totalLeaders ?? 0;
            document.getElementById('districts').innerText = data.totalDistricts ?? 0;

        })
        .catch(err => {
            console.error("Stats error:", err);
        });
}

// INIT
loadStats();

// AUTO REFRESH
setInterval(loadStats, 5000);
</script>

@endsection