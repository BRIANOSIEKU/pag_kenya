<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: Arial; font-size: 11px; }

h2 { text-align:center; }
h4 { text-align:center; }

table {
    width:100%;
    border-collapse: collapse;
    margin-top:20px;
}

th, td {
    border:1px solid #000;
    padding:6px;
}

th { background:#f2f2f2; }

.total {
    text-align:right;
    margin-top:15px;
    font-weight:bold;
}
</style>
</head>

<body>

<h2>{{ $district }} DISTRICT</h2>
<h4>ASSEMBLY TITHE SUMMARY (RANKED)</h4>

<p style="text-align:center;">
    Period: {{ $month }} / {{ $year }}
</p>

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

        @foreach($data as $i => $row)

            @php $grand += $row['total_tithe']; @endphp

            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['assembly'] }}</td>
                <td>{{ $row['pastor'] }}</td>
                <td>{{ $row['contact'] }}</td>
                <td>{{ number_format($row['total_tithe'], 2) }}</td>
            </tr>

        @endforeach

    </tbody>
</table>

<div class="total">
    TOTAL DISTRICT TITHE: {{ number_format($grand, 2) }}
</div>

</body>
</html>