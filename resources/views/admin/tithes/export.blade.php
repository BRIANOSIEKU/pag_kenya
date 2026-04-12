<!DOCTYPE html>
<html>
<head>
    <title>Tithe Report PDF</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .meta {
            text-align: center;
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #000;
            padding: 12px;
            margin-bottom: 15px;
        }

        .rejected {
            border: 2px solid #c62828;
            background: #fff5f5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #1e3c72;
            color: white;
        }
    </style>
</head>

<body>

<h2>PAG Kenya Tithe Report</h2>

<div class="meta">
    <p>
        Year: <b>{{ $year }}</b> |
        Month: <b>{{ $month }}</b> |
        Status: <b>{{ ucfirst($report->status ?? $status) }}</b>
    </p>
</div>

{{-- =========================
     REJECTED REPORT BLOCK
========================= --}}
@if(($report->status ?? $status) === 'rejected')

<div class="box rejected">

    <h3 style="color:#c62828;">REJECTED REPORT DETAILS</h3>

    <p><strong>District:</strong> {{ $report->district->name }}</p>

    <p><strong>Overseer:</strong>
        {{ $report->district->overseer->name ?? 'N/A' }}
    </p>

    <p><strong>Phone:</strong>
        {{ $report->district->overseer->contact ?? 'N/A' }}
    </p>

    <p><strong>Payment Code:</strong> {{ $report->payment_code }}</p>

    <p><strong>Total Amount:</strong>
        KES {{ number_format($report->total_amount, 2) }}
    </p>

    <p><strong style="color:#c62828;">Rejection Reason:</strong></p>
    <p style="border:1px dashed #c62828; padding:8px;">
        {{ $report->rejection_reason }}
    </p>

</div>

@endif

{{-- =========================
     TABLE (ONLY FOR NON-DETAILED VIEW)
========================= --}}
<table>
    <thead>
        <tr>
            <th>District</th>
            <th>Assembly</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @foreach($reports as $report)
            @foreach($report->items as $item)
                <tr>
                    <td>{{ $report->district->name }}</td>
                    <td>{{ $item->assembly->name ?? 'N/A' }}</td>
                    <td>KES {{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>