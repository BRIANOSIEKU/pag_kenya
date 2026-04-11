@extends('layouts.district_admin')

@section('content')

<h2 style="margin-bottom:10px;">Tithe Reports</h2>

<!-- NEW REPORT BUTTON -->
<a href="{{ route('district.admin.tithes.create') }}"
   style="padding:10px 14px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:15px;">
    + New Report
</a>

@if(session('success'))
<div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;">
    {{ session('success') }}
</div>
@endif

<!-- TABLE -->
<table style="width:100%; border-collapse:collapse; background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.08); border-radius:8px; overflow:hidden;">

    <thead>
        <tr style="background:#1e3c72;color:#fff;">
            <th style="padding:12px;">Year</th>
            <th>Month</th>
            <th>Payment Code</th>
            <th>Total (KES)</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        @forelse($reports as $report)
        <tr style="border-bottom:1px solid #eee;">

            <td style="padding:10px;">{{ $report->year }}</td>
            <td>{{ $report->month }}</td>
            <td>{{ $report->payment_code }}</td>
            <td style="font-weight:bold;">
                {{ number_format($report->total_amount, 2) }}
            </td>

            <!-- STATUS BADGE -->
            <td>
                @if($report->status == 'pending')
                    <span style="background:#FFC107;color:#000;padding:5px 10px;border-radius:20px;font-size:12px;">
                        Pending
                    </span>
                @elseif($report->status == 'approved')
                    <span style="background:#4CAF50;color:#fff;padding:5px 10px;border-radius:20px;font-size:12px;">
                        Approved
                    </span>
                @else
                    <span style="background:#F44336;color:#fff;padding:5px 10px;border-radius:20px;font-size:12px;">
                        Rejected
                    </span>
                @endif
            </td>

            <!-- ACTIONS -->
            <td>

                <!-- EDIT (ONLY IF PENDING) -->
                @if($report->status == 'pending')
                    <a href="{{ route('district.admin.tithes.edit', $report->id) }}"
                       style="background:#2196F3;color:#fff;padding:6px 10px;border-radius:5px;text-decoration:none;margin-right:5px;">
                        Edit
                    </a>
                @endif

                <!-- EXPORT PDF -->
                <a href="{{ route('district.admin.tithes.export', $report->id) }}"
                   style="background:#9C27B0;color:#fff;padding:6px 10px;border-radius:5px;text-decoration:none;">
                    Export PDF
                </a>

            </td>

        </tr>
        @empty

        <tr>
            <td colspan="6" style="text-align:center;padding:20px;">
                No reports found
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

@endsection