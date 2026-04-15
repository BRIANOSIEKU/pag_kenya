@extends('layouts.admin')

@section('content')

<style>
/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    max-width: 1200px;
    margin: auto;
    padding: 15px;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

/* ===== TITLE ===== */
.page-title {
    color: #1e3c72;
    font-size: 22px;
    margin: 0;
}

/* ===== SEARCH ===== */
.search-box {
    width: 280px;
    max-width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 10px 14px;
    border-radius: 6px;
    color: #fff;
    border: none;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
}

.btn-export { background: #28a745; }
.btn-review { background: #2196f3; }
.btn:hover { opacity: 0.85; }

/* ===== BACK BUTTON ===== */
.btn-back {
    background: #607D8B;
    color: white;
    padding: 10px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
}

.btn-back:hover { opacity: 0.85; }

/* ===== CARD ===== */
.card {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    margin-bottom: 15px;
}

/* ===== TABLE ===== */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

.table th {
    background: #1e3c72;
    color: white;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

/* ===== EXPORT BOX ===== */
.export-box {
    display: none;
}

/* ===== ALERTS ===== */
.alert-success {
    background: #d4edda;
    padding: 10px;
    color: #155724;
    margin-bottom: 10px;
    border-radius: 6px;
}

.alert-error {
    background: #f8d7da;
    padding: 10px;
    color: #721c24;
    margin-bottom: 10px;
    border-radius: 6px;
}

/* ===== HEADER RIGHT ===== */
.right {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .page-title {
        font-size: 18px;
    }

    .search-box {
        width: 100%;
    }

    .header {
        flex-direction: column;
        align-items: stretch;
    }

    .right {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="header">

        <!-- BACK -->
        <a href="{{ route('admin.districts.dashboard') }}" class="btn-back">
            ← Back to District Module Dashboard
        </a>

        <!-- TITLE -->
        <h2 class="page-title">Tithe Reports Verification Queue</h2>

        <!-- RIGHT CONTROLS -->
        <div class="right">

            <input type="text"
                   id="searchInput"
                   class="search-box"
                   placeholder="Search district, year, month...">

            <button class="btn btn-export" onclick="toggleExportBox()">
                Export Reports
            </button>

        </div>

    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    {{-- EXPORT BOX --}}
    <div class="card export-box" id="exportBox">

        <h3 style="margin-bottom:10px; color:#1e3c72;">Export Reports (PDF)</h3>

        <form method="GET" action="{{ route('admin.tithe_reports.export') }}">

            <label>Year</label>
            <input type="number" name="year" class="search-box" placeholder="e.g. 2026" required>

            <br><br>

            <label>Month</label>
            <select name="month" class="search-box" required>
                <option value="">Select Month</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}">
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>

            <br><br>

            <label>Status</label>
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

        <div class="table-wrapper">

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
                            <strong>KES {{ number_format($report->total_amount, 2) }}</strong>
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

</div>

{{-- LIVE SEARCH + TOGGLE --}}
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