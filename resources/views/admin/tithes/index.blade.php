@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1200px;
    margin: auto;
}

.header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
    flex-wrap:wrap;
    gap:10px;
}

.left, .right {
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
}

.search-box {
    width:280px;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
    outline:none;
}

.card {
    background:#fff;
    padding:15px;
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

.table {
    width:100%;
    border-collapse:collapse;
}

.table th {
    background:#1e3c72;
    color:white;
    padding:12px;
    text-align:left;
}

.table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

.btn {
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    cursor:pointer;
}

.btn-review {
    background:#2196f3;
}

.btn-export {
    background:#28a745;
}

/* EXPORT BOX */
.export-box {
    display:none;
    margin-top:15px;
}
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="header">

    <style>
    .btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}

.btn-back:hover {
    opacity: 0.85;
}
</style>

   <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
            ← Back to District Module Dashboard
        </a>


        {{-- LEFT --}}
        <div class="left">
            <h2 style="color:#1e3c72;">Tithe Reports Verification Queue</h2>
        </div>

        {{-- RIGHT --}}
        <div class="right">

            {{-- SEARCH --}}
            <input type="text"
                   id="searchInput"
                   class="search-box"
                   placeholder="Search district, year, month...">

            {{-- EXPORT BUTTON --}}
            <button class="btn btn-export"
                    onclick="toggleExportBox()">
                Export Reports
            </button>

        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div style="background:#d4edda; padding:10px; color:#155724; margin-bottom:10px; border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da; padding:10px; color:#721c24; margin-bottom:10px; border-radius:6px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- EXPORT FILTER BOX --}}
    <div class="card export-box" id="exportBox">

        <h3 style="margin-bottom:10px; color:#1e3c72;">Export Reports (PDF)</h3>

        <form method="GET" action="{{ route('admin.tithe_reports.export') }}">

            {{-- YEAR --}}
            <label>Year</label><br>
            <input type="number"
                   name="year"
                   class="search-box"
                   placeholder="e.g. 2026"
                   required>

            <br><br>

            {{-- MONTH --}}
            <label>Month</label><br>
            <select name="month" class="search-box" required>
                <option value="">Select Month</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}">
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>

            <br><br>

            {{-- STATUS --}}
            <label>Status</label><br>
            <select name="status" class="search-box" required>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>

            <br><br>

            <button type="submit" class="btn btn-export">
                Download PDF
            </button>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="card">

        <table class="table" id="reportsTable">

            <thead>
                <tr>
                    <th>#</th>
                    <th>District</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reports as $report)
                <tr class="report-row">

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->district->name }}</td>
                    <td>{{ $report->year }}</td>
                    <td>{{ $report->month }}</td>

                    <td>
                        <strong>
                            KES {{ number_format($report->total_amount, 2) }}
                        </strong>
                    </td>

                    <td>
                        <a class="btn btn-review"
                           href="{{ route('admin.tithe_review.show', $report->id) }}">
                            Review
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px;">
                        No pending reports found
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

{{-- LIVE SEARCH --}}
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {

    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll(".report-row");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });

});

// toggle export box
function toggleExportBox() {
    let box = document.getElementById("exportBox");
    box.style.display = (box.style.display === "none" || box.style.display === "")
        ? "block"
        : "none";
}
</script>

@endsection