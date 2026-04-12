<h2>Tithe Reports Export</h2>

<p><strong>Year:</strong> {{ $year }}</p>
<p><strong>Month:</strong> {{ $month }}</p>
<p><strong>Status:</strong> {{ ucfirst($status) }}</p>

<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>District</th>
            <th>Year</th>
            <th>Month</th>
            <th>Total Amount</th>
        </tr>
    </thead>

    <tbody>
        @foreach($reports as $report)
        <tr>
            <td>{{ $report->district->name }}</td>
            <td>{{ $report->year }}</td>
            <td>{{ $report->month }}</td>
            <td>KES {{ number_format($report->total_amount, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>