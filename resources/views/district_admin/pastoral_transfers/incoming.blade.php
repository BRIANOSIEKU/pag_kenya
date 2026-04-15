@extends('layouts.district_admin')

@section('content')

<style>
/* ===== GLOBAL SAFETY ===== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* ===== WRAPPER ===== */
.page-wrapper {
    padding: 15px;
    max-width: 100%;
}

/* ===== TITLE ===== */
h2 {
    margin-bottom: 15px;
    color: #1e3c72;
}

/* ===== MESSAGES ===== */
.success-box {
    background: #d4edda;
    padding: 10px;
    color: #155724;
    margin-bottom: 10px;
    border-radius: 6px;
}

.error-box {
    background: #f8d7da;
    padding: 10px;
    color: #721c24;
    margin-bottom: 10px;
    border-radius: 6px;
}

/* ===== CARD ===== */
.transfer-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* ===== TOP SECTION ===== */
.top-section {
    display: flex;
    gap: 15px;
    border-bottom: 1px solid #eee;
    padding-bottom: 12px;
    margin-bottom: 12px;
}

/* ===== PHOTO ===== */
.photo {
    width: 90px;
    height: 90px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #ddd;
    flex-shrink: 0;
}

/* ===== NAME ===== */
.name {
    margin: 0;
    font-size: 18px;
    color: #111;
}

/* ===== GRID INFO ===== */
.info-grid {
    margin-top: 8px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px;
    font-size: 13px;
    color: #444;
}

/* ===== SECTION HEADERS ===== */
.section-title {
    font-size: 14px;
    margin-bottom: 6px;
    color: #2c3e50;
}

/* ===== SMALL TEXT ===== */
.small-text {
    font-size: 13px;
    color: #555;
    line-height: 1.5;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

/* ===== ACTIONS ===== */
.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
    border-top: 1px solid #eee;
    padding-top: 10px;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    color: #fff;
}

.btn-approve { background: #28a745; }
.btn-reject { background: #dc3545; }

/* ===== INPUT ===== */
input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 220px;
}

/* ===== LINKS ===== */
a {
    word-break: break-word;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .top-section {
        flex-direction: column;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    input[type="text"] {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .page-wrapper {
        padding: 10px;
    }

    .photo {
        width: 80px;
        height: 80px;
    }
}
</style>

<div class="page-wrapper">

<h2>Incoming Transfer Requests</h2>

@if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="error-box">
        {{ session('error') }}
    </div>
@endif


@forelse($transfers as $transfer)

@php
    $dob = $transfer->pastor->date_of_birth
        ? \Carbon\Carbon::parse($transfer->pastor->date_of_birth)
        : null;

    $age = $dob ? $dob->age : 'N/A';
@endphp

<div class="transfer-card">

    {{-- TOP --}}
    <div class="top-section">

        {{-- PHOTO --}}
        @if($transfer->pastor->photo)
            <img src="{{ asset('storage/' . $transfer->pastor->photo) }}" class="photo">
        @else
            <div class="photo"></div>
        @endif

        {{-- INFO --}}
        <div style="flex:1;">

            <h3 class="name">
                {{ $transfer->pastor->name ?? 'N/A' }}
            </h3>

            <div class="info-grid">
                <div><b>Gender:</b> {{ $transfer->pastor->gender }}</div>
                <div><b>Phone:</b> {{ $transfer->pastor->contact }}</div>
                <div><b>DOB:</b> {{ $transfer->pastor->date_of_birth }}</div>
                <div><b>Age:</b> {{ $age }}</div>
                <div><b>Graduation:</b> {{ $transfer->pastor->graduation_year }}</div>
            </div>

        </div>

    </div>

    {{-- TRANSFER --}}
    <div>
        <div class="section-title">Transfer Details</div>

        <div class="small-text">
            <b>From:</b> {{ $transfer->fromDistrict->name ?? '' }} /
            {{ $transfer->fromAssembly->name ?? '' }} <br>

            <b>To:</b> {{ $transfer->toDistrict->name ?? '' }} /
            {{ $transfer->toAssembly->name ?? '' }}
        </div>

        <div style="margin-top:8px;">
            <b>Reason:</b>
            <div class="small-text">
                {{ $transfer->reason }}
            </div>
        </div>
    </div>

    {{-- CREDENTIALS --}}
    <div style="margin-top:12px;">
        <div class="section-title">Credentials</div>

        @if($transfer->pastor->attachments)
            @php
                $files = json_decode($transfer->pastor->attachments, true);
            @endphp

            <div class="small-text">
                @if(is_array($files))
                    @foreach($files as $file)
                        📎 <a href="{{ asset('storage/' . $file) }}" target="_blank">
                            View Credential
                        </a><br>
                    @endforeach
                @else
                    📎 <a href="{{ asset('storage/' . $transfer->pastor->attachments) }}" target="_blank">
                        View Document
                    </a>
                @endif
            </div>
        @else
            <span class="small-text">No credentials uploaded</span>
        @endif
    </div>

    {{-- TITHES --}}
    <div style="margin-top:12px;">
        <div class="section-title">Assembly Tithe Performance (Last 4 Months)</div>

        @if(isset($transfer->assemblyPerformance) && $transfer->assemblyPerformance->count())

            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Tithe</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transfer->assemblyPerformance as $perf)
                        <tr>
                            <td>{{ $perf->month ?? '' }} {{ $perf->year ?? '' }}</td>
                            <td>{{ number_format($perf->total ?? 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <span class="small-text">No tithe performance data available.</span>
        @endif
    </div>

    {{-- ACTIONS --}}
    @if($transfer->status == 'pending')

        <div class="actions">

            {{-- APPROVE --}}
            <form method="POST"
                  action="{{ route('district.admin.pastoral.transfers.approve', $transfer->id) }}">
                @csrf
                <button class="btn btn-approve">Approve</button>
            </form>

            {{-- REJECT --}}
            <form method="POST"
                  action="{{ route('district.admin.pastoral.transfers.reject', $transfer->id) }}">

                @csrf

                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <input type="text"
                           name="rejection_reason"
                           placeholder="Rejection reason..."
                           required>

                    <button class="btn btn-reject">Reject</button>
                </div>

            </form>

        </div>

    @else

        <div style="margin-top:10px;color:#777;font-size:13px;">
            This request has already been processed.
        </div>

    @endif

</div>

@empty
    <p>No incoming transfer requests found.</p>
@endforelse

</div>

@endsection