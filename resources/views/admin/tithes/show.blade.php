@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1100px;
    margin: auto;
}

.header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.badge {
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
    color:#fff;
}

.badge-pending { background:#ff9800; }
.badge-approved { background:#4caf50; }
.badge-rejected { background:#f44336; }

.card {
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 4px 12px rgba(0,0,0,0.06);
}

.grid {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap:15px;
}

.label {
    font-size:13px;
    color:#777;
}

.value {
    font-size:15px;
    font-weight:bold;
    color:#1e3c72;
}

.table {
    width:100%;
    border-collapse:collapse;
}

.table th {
    background:#1e3c72;
    color:white;
    padding:10px;
    text-align:left;
}

.table td {
    padding:10px;
    border-bottom:1px solid #eee;
}

.btn-group {
    display:flex;
    gap:10px;
}

.btn {
    padding:10px 15px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}

.btn-approve {
    background:#4caf50;
    color:white;
}

.btn-reject {
    background:#f44336;
    color:white;
}

.btn-link {
    display:inline-block;
    padding:8px 12px;
    background:#2196f3;
    color:white;
    border-radius:6px;
    text-decoration:none;
}
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <h2 style="color:#1e3c72;">Tithe Report Review</h2>

        <span class="badge 
            @if($report->status == 'pending') badge-pending
            @elseif($report->status == 'approved') badge-approved
            @elseif($report->status == 'rejected') badge-rejected
            @endif
        ">
            {{ strtoupper($report->status) }}
        </span>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div style="background:#d4edda; padding:10px; color:#155724; margin-bottom:15px; border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da; padding:10px; color:#721c24; margin-bottom:15px; border-radius:6px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- REJECTION REASON --}}
    @if($report->status === 'rejected' && $report->rejection_reason)
        <div style="background:#fff3cd; padding:12px; border-left:5px solid #f44336; margin-bottom:15px; border-radius:6px;">
            <strong style="color:#b71c1c;">Rejection Reason:</strong><br>
            {{ $report->rejection_reason }}
        </div>
    @endif

    {{-- REPORT SUMMARY --}}
    <div class="card">
        <div class="grid">

            <div>
                <div class="label">District</div>
                <div class="value" style="font-size:20px;">
                    {{ $report->district->name }}
                </div>
            </div>

            <div>
                <div class="label">Year</div>
                <div class="value" style="font-size:20px;">
                    {{ $report->year }}
                </div>
            </div>

            <div>
                <div class="label">Month</div>
                <div class="value" style="font-size:20px;">
                    {{ $report->month }}
                </div>
            </div>

            <div>
                <div class="label">Payment Code</div>
                <div class="value" style="font-size:20px;">
                    {{ $report->payment_code }}
                </div>
            </div>

            <div>
                <div class="label">Total Amount</div>
                <div class="value" style="font-size:22px; color:green;">
                    KES {{ number_format($report->total_amount, 2) }}
                </div>
            </div>

        </div>
    </div>

    {{-- OVERSEER --}}
    <div class="card">
        <h3 style="color:#1e3c72;">Overseer Details</h3>

        @if($report->district->overseer)
            <p><strong>Name:</strong> {{ $report->district->overseer->name }}</p>
            <p><strong>Contact:</strong> {{ $report->district->overseer->contact }}</p>
        @else
            <p style="color:red;">No Overseer assigned to this district</p>
        @endif
    </div>

    {{-- CONTRIBUTIONS (UPDATED WITH MUHTASARI COLUMN) --}}
    <div class="card">
        <h3 style="color:#1e3c72;">Assemblies Contributions</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Assembly</th>
                    <th>Amount</th>
                    <th>Muhtasari</th>
                </tr>
            </thead>

            <tbody>
                @foreach($report->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->assembly->name }}</td>

                    <td>
                        <strong>KES {{ number_format($item->amount, 2) }}</strong>
                    </td>

                    <td>
                        @if($item->assembly_muhtasari)
                            <a href="{{ asset('storage/' . $item->assembly_muhtasari) }}"
                               target="_blank"
                               style="display:inline-block;
                                      padding:6px 10px;
                                      background:#2196f3;
                                      color:#fff;
                                      border-radius:6px;
                                      text-decoration:none;">
                                📷 Click to view Muhtasari
                            </a>
                        @else
                            <span style="color:#999;">No image uploaded</span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- RECEIPT --}}
    <div class="card">
        <h3 style="color:#1e3c72;">Receipt / Muhtasary</h3>

        @if($report->receipt)
            <a class="btn-link" href="{{ asset('storage/'.$report->receipt) }}" target="_blank">
                View Receipt
            </a>
        @else
            <p>No receipt uploaded</p>
        @endif
    </div>

    {{-- ACTIONS --}}
    <div class="card">
        <h3 style="color:#1e3c72;">Actions</h3>

        <div class="btn-group">

            {{-- APPROVE --}}
            <form method="POST" action="{{ route('admin.tithe_review.approve', $report->id) }}">
                @csrf
                <button class="btn btn-approve">Approve Report</button>
            </form>

            {{-- REJECT --}}
            <form method="POST" action="{{ route('admin.tithe_review.reject', $report->id) }}">
                @csrf

                <div style="margin-bottom:10px; width:100%;">
                    <textarea name="rejection_reason" required
                        placeholder="Enter rejection reason..."
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"></textarea>
                </div>

                <button class="btn btn-reject">Reject Report</button>
            </form>

        </div>
    </div>

</div>

@endsection