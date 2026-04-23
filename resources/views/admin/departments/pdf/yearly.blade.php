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

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<table width="100%" style="border-collapse:collapse; border:none;">
    <tr>
        <td width="20%" style="vertical-align:top; border:none;">
            <img src="{{ public_path('images/pagk_logo.png') }}" 
                 style="width:120px; height:auto; border:none;">
        </td>

        <td width="80%" style="text-align:center; vertical-align:top; border:none;">

            <div class="main-title">
                PENTECOSTAL ASSEMBLIES OF GOD - KENYA
            </div>

            <div class="contact-info">
                Nyang’ori Mission Station Headquarters<br>
                P.O. Box 671 – 40100, KISUMU | 0726 078 479 | pagchurch671@gmail.com
            </div>

            <div style="margin-top:6px; font-style:italic; font-weight:bold;">
                YEARLY FINANCIAL REPORT
            </div>

            <div style="margin-top:6px; font-weight:bold; font-size:14px;">
                {{ $department->name ?? 'Department' }} Department
            </div>

        </td>
    </tr>
</table>

<hr style="border: 1px solid #00AEEF; margin-top:10px;">
<hr>

<!-- DATE -->
<p>
    <strong>Date:</strong> {{ \Carbon\Carbon::now()->format('l jS F Y') }}
</p>

<p>
    <strong>Year:</strong> {{ $year }}
</p>

<!-- SUMMARY -->
<div class="summary">
    <p><strong>Yearly Summary Report</strong></p>
</div>

<!-- TABLE -->
<div class="section-title">MONTHLY BREAKDOWN</div>

<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Opening</th>
            <th>Income</th>
            <th>Expense</th>
            <th>Closing</th>
        </tr>
    </thead>

    <tbody>
        @php
            $totalIncome = 0;
            $totalExpense = 0;
        @endphp

        @foreach($data as $row)

            @php
                $totalIncome += $row['income'];
                $totalExpense += $row['expense'];
            @endphp

            <tr>
                <td>
                    {{ DateTime::createFromFormat('!m', $row['month'])->format('F') }}
                </td>

                <td>{{ number_format($row['opening'], 2) }}</td>
                <td>{{ number_format($row['income'], 2) }}</td>
                <td>{{ number_format($row['expense'], 2) }}</td>
                <td>{{ number_format($row['closing'], 2) }}</td>
            </tr>

        @endforeach

        <!-- GRAND TOTAL -->
        <tr>
            <td class="bold">GRAND TOTAL</td>
            <td></td>
            <td class="bold">{{ number_format($totalIncome, 2) }}</td>
            <td class="bold">{{ number_format($totalExpense, 2) }}</td>
            <td class="bold">{{ number_format($grandBalance, 2) }}</td>
        </tr>
    </tbody>
</table>

<!-- FOOTER -->
<div class="footer">
    <hr>
    <p>Serving the Nations with Integrity & Accountability</p>
</div>

</body>
</html>