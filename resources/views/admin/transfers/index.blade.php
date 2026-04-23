@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    max-width: 1100px;
    margin: auto;
    padding: 15px;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    background: #607D8B;
    color: white;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}

.btn-back:hover { opacity: 0.85; }

/* ===== TITLE ===== */
.page-title {
    font-size: 20px;
    margin-bottom: 15px;
    color: #2c3e50;
}

/* ===== ALERTS ===== */
.alert-success {
    background: #d4edda;
    padding: 10px;
    color: #155724;
    margin-bottom: 10px;
    border-radius: 6px;
}

.alert-error {
    background: #f8d7da;
    padding: 10px;
    color: #721c24;
    margin-bottom: 10px;
    border-radius: 6px;
}

/* ===== TRANSFER CARD ===== */
.transfer-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* ===== HEADER SECTION ===== */
.transfer-header {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

/* ===== PHOTO ===== */
.photo {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #ddd;
}

/* ===== INFO ===== */
.info h3 {
    margin: 0;
    font-size: 18px;
}

.info small {
    color: #444;
    display: block;
    margin-top: 5px;
    line-height: 1.5;
}

/* ===== SECTION HEADINGS ===== */
.section-title {
    font-size: 14px;
    margin-bottom: 8px;
    color: #2c3e50;
}

/* ===== TABLES ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

th, td {
    padding: 8px;
    border: 1px solid #ddd;
    font-size: 13px;
}

th {
    background: #f1f1f1;
}

/* ===== ACTIONS ===== */
.actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 12px;
    border-top: 1px solid #eee;
    padding-top: 12px;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    border: none;
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    text-decoration: none;
}

.btn-approve { background: #28a745; }
.btn-reject { background: #dc3545; }
.btn-letter { background: #2c3e50; }
.btn-download { background: #16a085; }

.btn:hover { opacity: 0.85; }

/* ===== INPUT ===== */
.input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 220px;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .transfer-header {
        flex-direction: column;
        align-items: flex-start;
    }

    table { min-width: 500px; }

    .input { width: 100%; }

    .actions {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<div class="page-wrapper">

    {{-- BACK --}}
    <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
        ← Back to District Dashboard
    </a>

    {{-- TITLE (ROLE-AWARE) --}}
    <h2 class="page-title">
        Pending Transfer Requests

        @if(auth()->user()->hasRole('general_secretary'))
            (General Secretary View)
        @elseif(auth()->user()->hasRole('general_superintendent'))
            (General Superintendent View)
        @else
            (HQ View)
        @endif
    </h2>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    {{-- AUTO DOWNLOAD --}}
    @if(session('download_transfer_id'))
    <script>
        window.addEventListener('load', function () {
            let id = "{{ session('download_transfer_id') }}";
            window.location.href = "/admin/transfers/download-letter/" + id;
        });
    </script>
    @endif

    {{-- LOOP --}}
    @forelse($transfers as $transfer)

    @php
        $dob = $transfer->pastor->date_of_birth
            ? \Carbon\Carbon::parse($transfer->pastor->date_of_birth)
            : null;

        $age = $dob ? $dob->age : 'N/A';
    @endphp

    <div class="transfer-card">

        {{-- HEADER --}}
        <div class="transfer-header">

            <div>
                @if($transfer->pastor->photo)
                    <img src="{{ asset('storage/' . $transfer->pastor->photo) }}" class="photo">
                @else
                    <div class="photo" style="background:#ddd;"></div>
                @endif
            </div>

            <div class="info">
                <h3>{{ $transfer->pastor->name ?? 'N/A' }}</h3>

                <small>
                    <b>Current:</b>
                    {{ $transfer->fromDistrict->name ?? 'N/A' }} /
                    {{ $transfer->fromAssembly->name ?? 'N/A' }}

                    <br>

                    <b>Target:</b>
                    {{ $transfer->toDistrict->name ?? 'N/A' }} /
                    {{ $transfer->toAssembly->name ?? 'N/A' }}
                </small>
            </div>

        </div>

        {{-- PERFORMANCE TABLES (UNCHANGED) --}}
        <h4 class="section-title">Current Assembly Performance (Last 4 Months)</h4>

        <div class="table-wrapper">
        @if($transfer->currentAssemblyPerformance->count())
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Tithe (KES)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfer->currentAssemblyPerformance as $perf)
                    <tr>
                        <td>{{ $perf->month }} {{ $perf->year }}</td>
                        <td>{{ number_format($perf->total) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#888;">No data available.</p>
        @endif
        </div>

        {{-- TARGET --}}
        <h4 class="section-title" style="color:#27ae60;">Target Assembly Performance</h4>

        <div class="table-wrapper">
        @if($transfer->targetAssemblyPerformance->count())
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Tithe (KES)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfer->targetAssemblyPerformance as $perf)
                    <tr>
                        <td>{{ $perf->month }} {{ $perf->year }}</td>
                        <td>{{ number_format($perf->total) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#888;">No data available.</p>
        @endif
        </div>

        {{-- ACTIONS (ROLE BASED) --}}
        <div class="actions">

            {{-- SECRETARY --}}
            @if(auth()->user()->hasRole('general_secretary'))
                @if($transfer->general_secretary_approved == 0)
                <form method="POST" action="{{ route('admin.transfers.secretary.approve', $transfer->id) }}">
                    @csrf
                    <button class="btn btn-approve">Approve (Secretary)</button>
                </form>
                @endif
            @endif

            {{-- HQ / SUPERINTENDENT --}}
            @if(auth()->user()->hasRole(['general_superintendent','super_admin']))

                <form method="POST" action="{{ route('admin.transfers.approve', $transfer->id) }}">
                    @csrf
                    <button class="btn btn-approve">Final Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.transfers.reject', $transfer->id) }}">
                    @csrf
                    <input type="text" name="rejection_reason" class="input" placeholder="Reason..." required>
                    <button class="btn btn-reject">Reject</button>
                </form>

            @endif

            {{-- LETTER --}}
            @if($transfer->status === 'approved')
                <a href="{{ route('admin.transfers.letter', $transfer->id) }}" class="btn btn-letter">
                    View Letter
                </a>

                <a href="{{ route('admin.transfers.download', $transfer->id) }}" class="btn btn-download">
                    Download PDF
                </a>
            @endif

        </div>

    </div>

    @empty
        <p style="text-align:center; color:#888;">
            @if(auth()->user()->hasRole('general_secretary'))
                No transfers awaiting Secretary approval.
            @elseif(auth()->user()->hasRole('general_superintendent'))
                No transfers pending Superintendent approval.
            @else
                No pending transfers found.
            @endif
        </p>
    @endforelse

</div>

@endsection