@extends('layouts.admin')

@section('content')

<div class="container">

    <h2 style="margin-bottom:20px;">Departments Finance Reports</h2>

    <form method="GET" id="reportForm">

        {{-- ================= DEPARTMENT ================= --}}
        <label>Select Department</label>
        <select name="department_id" id="department" required style="width:100%; padding:10px; margin-bottom:15px;">
            <option value="">-- Select Department --</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
            @endforeach
        </select>

        {{-- ================= REPORT TYPE ================= --}}
        <label>Report Type</label>
        <select id="reportType" required style="width:100%; padding:10px; margin-bottom:15px;">
            <option value="">-- Select Report Type --</option>
            <option value="monthly">Monthly Report</option>
            <option value="yearly">Yearly Report</option>
        </select>

        {{-- ================= MONTHLY OPTIONS ================= --}}
        <div id="monthlySection" style="display:none;">
            <label>Select Month</label>
            <select name="month" style="width:100%; padding:10px; margin-bottom:10px;">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}">
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endfor
            </select>

            <label>Year</label>
            <input type="number" name="year" value="{{ now()->year }}" style="width:100%; padding:10px; margin-bottom:15px;">
        </div>

        {{-- ================= YEARLY OPTIONS ================= --}}
        <div id="yearlySection" style="display:none;">
            <label>Enter Year</label>
            <input type="number" name="year" value="{{ now()->year }}" style="width:100%; padding:10px; margin-bottom:15px;">
        </div>

        {{-- ================= BUTTON ================= --}}
        <button type="submit"
            style="width:100%; padding:12px; background:#1e3c72; color:#fff; border:none; border-radius:6px;">
            Download Report
        </button>

    </form>

</div>

{{-- ================= SCRIPT ================= --}}
<script>
const reportType = document.getElementById('reportType');
const monthlySection = document.getElementById('monthlySection');
const yearlySection = document.getElementById('yearlySection');
const form = document.getElementById('reportForm');

reportType.addEventListener('change', function() {

    monthlySection.style.display = 'none';
    yearlySection.style.display = 'none';

    if (this.value === 'monthly') {
        monthlySection.style.display = 'block';
        form.action = "{{ route('admin.departments.finance.reports.monthly') }}";
    }

    if (this.value === 'yearly') {
        yearlySection.style.display = 'block';
        form.action = "{{ route('admin.departments.finance.reports.yearly') }}";
    }

});
</script>

@endsection