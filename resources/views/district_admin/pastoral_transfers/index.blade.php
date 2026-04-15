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

/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    padding: 15px;
    max-width: 100%;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}

.btn-back:hover {
    opacity: 0.85;
}

/* ===== HEADER ROW ===== */
.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

h2 {
    color: #1e3c72;
    margin: 0;
}

/* ===== NEW BUTTON ===== */
.btn-new {
    padding: 10px 15px;
    background: #28a745;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    font-weight: bold;
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

/* ===== TABLE WRAPPER ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px; /* prevents overflow break */
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    white-space: nowrap;
    text-align: left;
}

thead {
    background: #343a40;
    color: #fff;
}

/* ===== ACTION BUTTONS ===== */
.action-btn {
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 12px;
    display: inline-block;
    margin-right: 5px;
}

.edit-btn { background: #007bff; }
.delete-btn { background: #dc3545; border: none; cursor: pointer; }
.download-btn { background: #28a745; }

/* ===== STATUS TEXT ===== */
.status-green { color: green; font-weight: bold; }
.status-red { color: red; font-weight: bold; }
.status-orange { color: orange; font-weight: bold; }

/* ===== SMALL TEXT ===== */
.small-text {
    font-size: 12px;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    table {
        min-width: 800px;
    }
}

@media (max-width: 480px) {
    .page-wrapper {
        padding: 10px;
    }

    .header-row {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="page-wrapper">

    <!-- BACK -->
    <a href="{{ route('district.admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <!-- HEADER -->
    <div class="header-row">
        <h2>Pastoral Transfers</h2>

        <a href="{{ route('district.admin.pastoral.transfers.create') }}"
           class="btn-new">
            + New Transfer
        </a>
    </div>

    <!-- MESSAGES -->
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

    <!-- TABLE -->
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Pastor</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transfers as $transfer)

                    @php
                        $isSameDistrict = $transfer->from_district_id == $transfer->to_district_id;

                        $canDownloadLetter =
                            ($isSameDistrict && $transfer->status === 'approved')
                            ||
                            (!$isSameDistrict &&
                             $transfer->to_district_approved &&
                             $transfer->status === 'approved');
                    @endphp

                    <tr>

                        <!-- PASTOR -->
                        <td>{{ $transfer->pastor->name ?? 'N/A' }}</td>

                        <!-- FROM -->
                        <td>
                            {{ $transfer->fromDistrict->name ?? '' }} /
                            {{ $transfer->fromAssembly->name ?? '' }}
                        </td>

                        <!-- TO -->
                        <td>
                            {{ $transfer->toDistrict->name ?? '' }} /
                            {{ $transfer->toAssembly->name ?? '' }}
                        </td>

                        <!-- STATUS -->
                        <td class="small-text">

                            @if($isSameDistrict)

                                Final:
                                @if($transfer->status == 'approved')
                                    <span class="status-green">Approved</span>
                                @elseif($transfer->status == 'rejected')
                                    <span class="status-red">Rejected</span>
                                @else
                                    <span class="status-orange">Pending</span>
                                @endif

                            @else

                                District:
                                @if($transfer->to_district_approved)
                                    <span class="status-green">✔ Approved</span>
                                @else
                                    <span class="status-orange">Pending</span>
                                @endif

                                <br>

                                Final:
                                @if($transfer->status == 'approved')
                                    <span class="status-green">Approved</span>
                                @elseif($transfer->status == 'rejected')
                                    <span class="status-red">Rejected</span>
                                @else
                                    <span class="status-orange">Pending</span>
                                @endif

                            @endif

                            @if($transfer->status == 'rejected' && $transfer->rejection_reason)
                                <div style="color:red;margin-top:5px;">
                                    {{ $transfer->rejection_reason }}
                                </div>
                            @endif

                        </td>

                        <!-- ACTIONS -->
                        <td>

                            @if($transfer->status == 'pending')

                                <a href="{{ route('district.admin.pastoral.transfers.edit', $transfer->id) }}"
                                   class="action-btn edit-btn">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('district.admin.pastoral.transfers.destroy', $transfer->id) }}"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Delete this transfer?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="action-btn delete-btn">
                                        Delete
                                    </button>

                                </form>

                            @else

                                @if($canDownloadLetter)

                                    <a href="{{ route('district.admin.pastoral.transfers.download', $transfer->id) }}"
                                       class="action-btn download-btn">
                                        Download Letter
                                    </a>

                                @else

                                    <em style="color:#888;font-size:12px;">Locked</em>

                                @endif

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" style="text-align:center;padding:20px;">
                            No transfers found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection