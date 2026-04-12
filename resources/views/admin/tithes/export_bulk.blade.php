<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }

        .header img {
            width: 130px;
            margin-bottom: 8px;
        }

        h2 {
            margin: 0;
            font-size: 18px;
        }

        h3 {
            margin: 3px 0 0 0;
            font-size: 14px;
            font-weight: normal;
        }

        .meta {
            margin-top: 8px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #f2f2f2;
        }

        th, td {
            padding: 8px;
            font-size: 11px;
        }

        .rejected-header {
            background: #ffe6e6;
            color: #c62828;
            font-weight: bold;
            text-align: center;
        }

        .summary {
            margin-top: 15px;
            font-weight: bold;
            text-align: right;
        }

    </style>
</head>

<body>

<div class="header">

    <img src="{{ public_path('images/pagk_logo.png') }}" alt="Logo">

    <h2>PENTECOSTAL ASSEMBLIES OF GOD KENYA CHURCH</h2>

    <h3>TITHE REPORTS SUMMARY ({{ strtoupper($status) }})</h3>

    <div class="meta">
        Year: {{ $year }} |
        Month: {{ $month }} |
        Generated: {{ now()->format('d M Y H:i') }}
    </div>

</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>District</th>
            <th>Assembly / Details</th>
            <th>Payment Code</th>
            <th>Year</th>
            <th>Month</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>

        @php $total = 0; $i = 1; @endphp

        @forelse($reports as $report)

            {{-- =========================
                 REJECTED REPORTS
            ========================= --}}
            @if($report->status == 'rejected')

                <tr>
                    <td colspan="7" class="rejected-header">
                        REJECTED REPORT
                    </td>
                </tr>

                <tr>
                    <td>{{ $i++ }}</td>

                    <td>
                        {{ $report->district->name ?? 'N/A' }}
                        <br>
                        <small>
                            Overseer: {{ $report->district->overseer->name ?? 'N/A' }}<br>
                            Contact: {{ $report->district->overseer->contact ?? 'N/A' }}
                        </small>
                    </td>

                    <td colspan="2">
                        Payment Code: {{ $report->payment_code }}
                    </td>

                    <td>{{ $report->year }}</td>
                    <td>{{ $report->month }}</td>

                    <td>
                        <strong>KES {{ number_format($report->total_amount ?? 0, 2) }}</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" style="color:#c62828; padding:10px;">
                        <strong>Rejection Reason:</strong><br>
                        {{ $report->rejection_reason ?? 'N/A' }}
                    </td>
                </tr>

                @php $total += $report->total_amount ?? 0; @endphp

            @else

                {{-- =========================
                     NORMAL REPORTS
                ========================= --}}
                @foreach($report->items as $item)

                    <tr>

                        <td>{{ $i++ }}</td>
                        <td>{{ $report->district->name ?? 'N/A' }}</td>
                        <td>{{ $item->assembly->name ?? 'N/A' }}</td>
                        <td>{{ $report->payment_code }}</td>
                        <td>{{ $report->year }}</td>
                        <td>{{ $report->month }}</td>
                        <td>{{ number_format($item->amount ?? 0, 2) }}</td>

                    </tr>

                    @php $total += $item->amount ?? 0; @endphp

                @endforeach

            @endif

        @empty
            <tr>
                <td colspan="7" style="text-align:center;">
                    No reports found
                </td>
            </tr>
        @endforelse

    </tbody>
</table>

<div class="summary">
    TOTAL AMOUNT: KES {{ number_format($total, 2) }}
</div>

{{-- =========================
     CLEAN APPROVED SIGNATURES
========================= --}}
@if($status == 'approved')

<div style="margin-top:80px; text-align:center;">

    <h4 style="margin-bottom:50px;">
        OFFICIAL APPROVAL SIGNATURES
    </h4>

    <table style="width:100%; border:none;">
        <tr>

            {{-- GENERAL TREASURER --}}
            <td style="text-align:center; border:none;">
                <div style="width:70%; margin:0 auto; border-top:1px solid #000;"></div>
                <p style="margin-top:8px; font-weight:bold;">
                    General Treasurer
                </p>
            </td>

            {{-- GENERAL SECRETARY --}}
            <td style="text-align:center; border:none;">
                <div style="width:70%; margin:0 auto; border-top:1px solid #000;"></div>
                <p style="margin-top:8px; font-weight:bold;">
                    General Secretary
                </p>
            </td>

            {{-- GENERAL SUPERINTENDENT --}}
            <td style="text-align:center; border:none;">
                <div style="width:70%; margin:0 auto; border-top:1px solid #000;"></div>
                <p style="margin-top:8px; font-weight:bold;">
                    General Superintendent
                </p>
            </td>

        </tr>
    </table>

</div>

@endif

</body>
</html>