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
            height: auto;
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
            font-weight: bold;
        }

        th, td {
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        .empty {
            text-align: center;
            padding: 15px;
        }
    </style>
</head>

<body>

<div class="header">

    <!-- FIXED LOGO PATH FOR DOMPDF -->
    <img src="{{ public_path('images/pagk_logo.png') }}" alt="Church Logo">

    <h2>PENTECOSTAL ASSEMBLIES OF GOD KENYA CHURCH</h2>

    <h3>LIST OF {{ strtoupper($category) }}S</h3>

    <div class="meta">
        Generated on: {{ $date->format('d M Y H:i') }}
    </div>

</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>National ID</th>
            <th>Phone</th>
            <th>District</th>
            <th>Gender</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaders as $index => $leader)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $leader->name }}</td>
                <td>{{ $leader->national_id }}</td>
                <td>{{ $leader->contact }}</td>
                <td>{{ $leader->district->name ?? 'N/A' }}</td>
                <td>{{ $leader->gender }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="empty">
                    No records found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>