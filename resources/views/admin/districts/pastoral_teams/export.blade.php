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

    <img src="{{ public_path('images/pagk_logo.png') }}" alt="Church Logo">

    <h2>PENTECOSTAL ASSEMBLIES OF GOD KENYA CHURCH</h2>

    <h3>ALL PASTORAL TEAMS REPORT</h3>

    <div class="meta">
        Generated on:
        {{ \Carbon\Carbon::now('Africa/Nairobi')->format('d M Y H:i') }}
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
            <th>Assembly</th>
            <th>Gender</th>
            <th>Year of Graduation</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pastors as $index => $pastor)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pastor->name }}</td>
                <td>{{ $pastor->national_id }}</td>
                <td>{{ $pastor->contact }}</td>
                <td>{{ $pastor->district->name ?? 'N/A' }}</td>
                <td>{{ $pastor->assembly->name ?? 'N/A' }}</td>
                <td>{{ $pastor->gender }}</td>

                <td>
                    {{ $pastor->year_of_graduation ?? 'N/A' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="empty">
                    No pastors found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>