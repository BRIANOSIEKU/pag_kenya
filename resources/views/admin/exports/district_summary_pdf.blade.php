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
            width: 120px;
            margin-bottom: 10px;
        }

        h2 { margin: 0; font-size: 18px; }
        h3 { margin: 5px 0; font-size: 14px; font-weight: normal; }

        .meta {
            font-size: 11px;
            margin-top: 5px;
            text-align: center;
        }

        .district-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .overseer-box {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        th {
            background: #f2f2f2;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>

<div class="header">
    <img src="{{ public_path('images/pagk_logo.png') }}" alt="Logo">

    <h2>PENTECOSTAL ASSEMBLIES OF GOD KENYA CHURCH</h2>
    <h3>DISTRICT SUMMARY REPORT</h3>
</div>

<div class="district-title">
    {{ $district->name ?? 'N/A' }}
</div>

<div class="overseer-box">
    <strong>Overseer:</strong> {{ $overseer->name ?? 'N/A' }}
    |
    <strong>Contact:</strong> {{ $overseer->contact ?? 'N/A' }}
</div>

<div class="meta">
    Period: {{ $month }} / {{ $year }}
</div>

@php
    $grand = 0;
@endphp

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Assembly</th>
            <th>Pastor</th>
            <th>Contact</th>
            <th>Total Tithe</th>
        </tr>
    </thead>

    <tbody>

        @forelse($data as $i => $row)

            @php
                $amount = (float) $row->total_tithe;
                $grand += $amount;
            @endphp

            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->assembly_name }}</td>
                <td>{{ $row->pastor_name }}</td>
                <td>{{ $row->contact }}</td>
                <td>{{ number_format($amount, 2) }}</td>
            </tr>

        @empty
            <tr>
                <td colspan="5" class="empty">No records found</td>
            </tr>
        @endforelse

    </tbody>
</table>

<div class="total">
    TOTAL DISTRICT TITHE: {{ number_format($grand, 2) }}
</div>

</body>
</html>