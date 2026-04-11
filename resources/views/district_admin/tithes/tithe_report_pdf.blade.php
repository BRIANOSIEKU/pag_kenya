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
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }

        .header img {
            width: 110px;
            margin-bottom: 5px;
        }

        h2 {
            margin: 0;
            font-size: 16px;
        }

        h3 {
            margin: 3px 0;
            font-size: 13px;
            font-weight: normal;
        }

        .district {
            text-align: center;
            font-size: 13px;
            margin-top: 5px;
            font-weight: bold;
        }

        .meta {
            margin-top: 10px;
            font-size: 11px;
            text-align: center;
            line-height: 1.6;
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
            font-weight: bold;
        }

        th, td {
            padding: 7px;
            font-size: 11px;
            text-align: left;
        }

        .total {
            margin-top: 12px;
            text-align: right;
            font-weight: bold;
            font-size: 13px;
        }

        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .sign-box {
            text-align: center;
            width: 45%;
        }

        .line {
            margin-top: 50px;
            border-top: 1px solid #000;
        }

        .empty {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">

    <img src="{{ public_path('images/pagk_logo.png') }}" alt="Logo">

    <h2>PENTECOSTAL ASSEMBLIES OF GOD KENYA</h2>
    <h3>DISTRICT TITHE REPORT</h3>

    <!-- DISTRICT -->
    <div class="district">
        DISTRICT: {{ $report->district->name ?? 'N/A' }}
    </div>

    <!-- META INFO -->
    <div class="meta">
        <div><strong>REPORT PERIOD:</strong> {{ strtoupper($report->month) }} {{ $report->year }}</div>
        <div><strong>PAYMENT CODE:</strong> {{ $report->payment_code }}</div>
        <div><strong>GENERATED:</strong> {{ now()->format('d M Y H:i') }}</div>
    </div>

</div>

<!-- TABLE -->
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Assembly</th>
            <th>Amount (KES)</th>
        </tr>
    </thead>

    <tbody>
        @forelse($report->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->assembly->name ?? 'N/A' }}</td>
                <td>{{ number_format($item->amount, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="empty">No records found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- TOTAL -->
<div class="total">
    TOTAL AMOUNT: KES {{ number_format($report->total_amount, 2) }}
</div>

<!-- SIGNATURES -->
<div class="signature">

    <div class="sign-box">
        <div class="line"></div>
        DISTRICT OVERSEER
    </div>

    <div class="sign-box">
        <div class="line"></div>
        DISTRICT TREASURER
    </div>

</div>

</body>
</html>