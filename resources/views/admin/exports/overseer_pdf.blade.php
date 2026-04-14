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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #f2f2f2;
            font-size: 11px;
            padding: 8px;
            text-align: left;
        }

        td {
            font-size: 11px;
            padding: 7px;
        }

        .empty {
            text-align: center;
            padding: 15px;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            font-size: 13px;
        }

        /* =========================
           SIGNATURE SECTION (NO FRAMES)
        ========================= */
        .signatures {
            margin-top: 90px;
            width: 100%;
        }

        .sign-row {
            width: 100%;
            text-align: center;
        }

        .sign-box {
            display: inline-block;
            width: 32%;
            text-align: center;
            vertical-align: bottom;
        }

        .sig-line {
            width: 70%;
            margin: 0 auto 6px auto;
            border-top: 1px solid #000;
        }

        .role {
            font-weight: bold;
            font-size: 11px;
        }

        .footer-note {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .powered {
            margin-top: 5px;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

<div class="header">
    <img src="{{ public_path('images/pagk_logo.png') }}" alt="Logo">

    <h2>PENTECOSTAL ASSEMBLIES OF GOD KENYA CHURCH</h2>
    <h3>OVERSEER REIMBURSEMENT REPORT</h3>

    <div class="meta">
        Period: {{ $month ?? 'N/A' }} / {{ $year ?? 'N/A' }}
    </div>
</div>

@php
    $leaders = $leaders ?? [];
    $total = 0;
@endphp

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>District</th>
            <th>ID</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Bank</th>
            <th>Branch</th>
            <th>Account</th>
            <th>Amount (15%)</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaders as $index => $row)

            @php
                $amount = (float) ($row['amount'] ?? 0);
                $total += $amount;
            @endphp

            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['district'] }}</td>
                <td>{{ $row['national_id'] }}</td>
                <td>{{ $row['gender'] }}</td>
                <td>{{ $row['phone'] }}</td>
                <td>{{ $row['bank'] }}</td>
                <td>{{ $row['branch'] }}</td>
                <td>{{ $row['account'] }}</td>
                <td>{{ number_format($amount, 2) }}</td>
            </tr>

        @empty
            <tr>
                <td colspan="10" class="empty">No records found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="total">
    TOTAL PAYABLE: {{ number_format($total, 2) }}
</div>

<!-- =========================
     SIGNATURES (CLEAN NO BOXES)
========================= -->
<div class="signatures">
    <div class="sign-row">

        <div class="sign-box">
            <div class="sig-line"></div>
            <div class="role">GENERAL TREASURER</div>
        </div>

        <div class="sign-box">
            <div class="sig-line"></div>
            <div class="role">GENERAL SECRETARY</div>
        </div>

        <div class="sign-box">
            <div class="sig-line"></div>
            <div class="role">GENERAL SUPERINTENDENT</div>
        </div>

    </div>
</div>

<!-- FOOTER -->
<div class="footer-note">
    This document is system generated.
    <div class="powered">Powered by PAG - K Church Management System</div>
</div>

</body>
</html>