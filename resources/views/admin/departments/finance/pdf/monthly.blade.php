<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
            color: #000;
            padding: 30px;
        }

        .main-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .contact-info {
            font-size: 11px;
            text-align: center;
        }

        hr {
            border: 1px solid #00AEEF;
            margin: 10px 0;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #1e3c72;
            color: #fff;
            padding: 6px;
            font-size: 12px;
        }

        td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12px;
        }

        .summary {
            margin-top: 15px;
        }

        .summary p {
            margin: 2px 0;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            text-align: center;
            width: 100%;
        }

        .footer hr {
            border: 1px solid #00AEEF;
            width: 80%;
        }

        .footer p {
            color: #00AEEF;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<table width="100%" style="border-collapse:collapse; border:none;">
    <tr>
        <!-- LOGO -->
        <td width="20%" style="vertical-align:top; border:none;">
            <img src="{{ public_path('images/pagk_logo.png') }}" 
                 style="width:120px; height:auto; border:none;">
        </td>

        <!-- TEXT -->
        <td width="80%" style="text-align:center; vertical-align:top; border:none;">

            <div class="main-title">
                PENTECOSTAL ASSEMBLIES OF GOD - KENYA
            </div>

            <div class="contact-info">
                Nyang’ori Mission Station Headquarters<br>
                P.O. Box 671 – 40100, KISUMU | 0726 078 479 | pagchurch671@gmail.com
            </div>

            <div style="margin-top:6px; font-style:italic; font-weight:bold;">
                FINANCIAL MONTHLY REPORT
            </div>

            <!-- DEPARTMENT TITLE -->
            <div style="margin-top:6px; font-weight:bold; font-size:14px;">
                {{ $department->name ?? 'Department' }} Department
            </div>

        </td>
    </tr>
</table>

<!-- SINGLE CLEAN LINE -->
<hr style="border: 1px solid #00AEEF; margin-top:10px;">
<hr>

<!-- DATE + PERIOD -->
<p>
    <strong>Date:</strong> {{ \Carbon\Carbon::now()->format('l jS F Y') }}
</p>

<p>
    <strong>Period:</strong> {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
</p>

<!-- SUMMARY -->
<div class="summary">
    <p><strong>Opening Balance:</strong> KES {{ number_format($openingBalance, 2) }}</p>
    <p><strong>Total Income:</strong> KES {{ number_format($income, 2) }}</p>
    <p><strong>Total Expense:</strong> KES {{ number_format($expense, 2) }}</p>
    <p><strong>Closing Balance:</strong> KES {{ number_format($closingBalance, 2) }}</p>
</div>

<!-- TRANSACTIONS TABLE -->
<div class="section-title">DETAILED TRANSACTIONS</div>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Title</th>
            <th>Payment Mode</th>
            <th>Bank/Mpesa</th>
            <th>Account Ref</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @forelse($transactions as $t)
            <tr>
                <td>{{ $t->transaction_date }}</td>
                <td>{{ ucfirst($t->type) }}</td>
                <td>{{ $t->title }}</td>
                <td>{{ ucfirst($t->payment_mode) }}</td>
                <td>{{ $t->bank_name ?? 'Mpesa' }}</td>
                <td>{{ $t->account_reference ?? '-' }}</td>
                <td>KES {{ number_format($t->amount, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center;">
                    No transactions for this period
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- FOOTER -->
<div class="footer">
    <hr>
    <p>Serving the Nations with Integrity & Accountability</p>
</div>

</body>
</html>