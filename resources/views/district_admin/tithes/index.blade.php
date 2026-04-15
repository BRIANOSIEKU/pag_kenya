@extends('layouts.district_admin')

@section('content')

<style>
/* ===== GLOBAL SAFETY FIX ===== */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* ===== WRAPPER ===== */
.page-wrapper {
    padding: 15px;
    max-width: 100%;
    overflow-x: hidden;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    background: #607D8B;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}

.btn-back:hover {
    opacity: 0.85;
}

/* ===== TITLE ===== */
.page-title {
    margin-bottom: 10px;
}

/* ===== NEW BUTTON ===== */
.btn-new {
    padding: 10px 14px;
    background: #4CAF50;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 15px;
}

/* ===== FILTERS ===== */
.filter-box {
    margin-bottom: 15px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-box input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    max-width: 100%;
}

/* ===== TABLE CONTAINER (IMPORTANT FOR MOBILE) ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
    min-width: 700px; /* allows scroll instead of breaking layout */
}

thead tr {
    background: #1e3c72;
    color: #fff;
}

th, td {
    padding: 12px;
    text-align: left;
    white-space: nowrap;
}

tr {
    border-bottom: 1px solid #eee;
}

/* ===== STATUS BADGES ===== */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}

.pending { background: #FFC107; color: #000; }
.approved { background: #4CAF50; color: #fff; }
.rejected { background: #F44336; color: #fff; }

/* ===== ACTION BUTTONS ===== */
.action-btn {
    padding: 6px 10px;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    display: inline-block;
    margin-right: 5px;
    font-size: 13px;
}

.edit-btn { background: #2196F3; }
.export-btn { background: #9C27B0; }

/* ===== SUCCESS MESSAGE ===== */
.success-box {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 768px) {

    .filter-box {
        flex-direction: column;
    }

    table {
        min-width: 600px;
    }
}

@media (max-width: 480px) {

    .page-wrapper {
        padding: 10px;
    }

    th, td {
        padding: 10px;
        font-size: 13px;
    }

    .action-btn {
        display: block;
        margin-bottom: 5px;
        text-align: center;
    }
}

</style>

<div class="page-wrapper">

    <!-- BACK -->
    <a href="{{ route('district.admin.dashboard') }}" class="btn-back">
        ← Back to Dashboard
    </a>

    <!-- TITLE -->
    <h2 class="page-title">Tithe Reports</h2>

    <!-- NEW REPORT -->
    <a href="{{ route('district.admin.tithes.create') }}" class="btn-new">
        + New Report
    </a>

    <!-- SUCCESS -->
    @if(session('success'))
    <div class="success-box">
        {{ session('success') }}
    </div>
    @endif

    <!-- FILTERS -->
    <div class="filter-box">
        <input type="number" id="yearSearch" placeholder="Search Year">
        <input type="text" id="monthSearch" placeholder="Search Month (e.g March)">
    </div>

    <!-- TABLE -->
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Payment Code</th>
                    <th>Total (KES)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($reports as $report)
                <tr class="report-row"
                    data-year="{{ $report->year }}"
                    data-month="{{ strtolower($report->month) }}"
                    @if($report->status == 'rejected') style="background:#fff5f5;" @endif>

                    <td>{{ $report->year }}</td>
                    <td>{{ $report->month }}</td>
                    <td>{{ $report->payment_code }}</td>
                    <td><strong>{{ number_format($report->total_amount, 2) }}</strong></td>

                    <!-- STATUS -->
                    <td>
                        @if($report->status == 'pending')
                            <span class="badge pending">Pending</span>

                        @elseif($report->status == 'approved')
                            <span class="badge approved">Approved</span>

                        @else
                            <span class="badge rejected">Rejected</span>

                            @if($report->rejection_reason)
                                <div style="font-size:12px;color:#b71c1c;margin-top:5px;">
                                    <strong>Reason:</strong> {{ $report->rejection_reason }}
                                </div>
                            @endif
                        @endif
                    </td>

                    <!-- ACTIONS -->
                    <td>

                        @if(in_array($report->status, ['pending', 'rejected']))
                            <a href="{{ route('district.admin.tithes.edit', $report->id) }}"
                               class="action-btn edit-btn">
                                Edit
                            </a>
                        @endif

                        <a href="{{ route('district.admin.tithes.export', $report->id) }}"
                           class="action-btn export-btn">
                            Export PDF
                        </a>

                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="6" style="text-align:center;padding:20px;">
                        No reports found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- FILTER SCRIPT -->
<script>
const yearInput = document.getElementById('yearSearch');
const monthInput = document.getElementById('monthSearch');
const rows = document.querySelectorAll('.report-row');

function filterReports() {
    let yearValue = yearInput.value.toLowerCase();
    let monthValue = monthInput.value.toLowerCase();

    rows.forEach(row => {
        let year = row.getAttribute('data-year').toLowerCase();
        let month = row.getAttribute('data-month');

        let matchYear = year.includes(yearValue);
        let matchMonth = month.includes(monthValue);

        row.style.display = (matchYear && matchMonth) ? '' : 'none';
    });
}

yearInput.addEventListener('input', filterReports);
monthInput.addEventListener('input', filterReports);
</script>

@endsection