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

/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    padding: 15px;
    max-width: 100%;
    overflow-x: hidden;
}

/* ===== ERROR BOX ===== */
.error-box {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* ===== FORM ===== */
form {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* ===== INPUTS ===== */
input[type="number"],
input[type="text"],
select,
input[type="file"] {
    width: 100%;
    max-width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

/* ===== TITLES ===== */
h2, h3 {
    color: #1e3c72;
}

/* ===== TABLE WRAPPER ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    text-align: left;
    white-space: nowrap;
}

thead {
    background: #1e3c72;
    color: #fff;
}

/* ===== LINKS ===== */
a {
    color: #2196F3;
    text-decoration: none;
}

/* ===== TOTAL ===== */
.total-box {
    font-size: 18px;
    font-weight: bold;
    margin-top: 10px;
    color: #333;
}

/* ===== BUTTON ===== */
button {
    background: #2196F3;
    color: #fff;
    padding: 12px 18px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    width: 100%;
    cursor: pointer;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    form {
        padding: 15px;
    }

    table {
        min-width: 650px;
    }
}

@media (max-width: 480px) {
    .page-wrapper {
        padding: 10px;
    }

    th, td {
        font-size: 13px;
    }

    button {
        font-size: 16px;
    }
}
</style>

<div class="page-wrapper">

<h2>Edit Tithe Report</h2>

<!-- ERROR -->
@if(session('error'))
<div class="error-box">
    {{ session('error') }}
</div>
@endif

<form method="POST"
      action="{{ route('district.admin.tithes.update', $report->id) }}"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<!-- YEAR -->
<label>Year</label>
<input type="number" name="year" value="{{ $report->year }}" required>

<!-- MONTH -->
<label>Month</label>
<select name="month" required>
    @foreach([
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ] as $month)
        <option value="{{ $month }}" {{ $report->month == $month ? 'selected' : '' }}>
            {{ $month }}
        </option>
    @endforeach
</select>

<!-- PAYMENT CODE -->
<label>Payment Code</label>
<input type="text" name="payment_code" value="{{ $report->payment_code }}" required>

<h3>Update Assemblies</h3>

<div class="table-container">

<table>

    <thead>
        <tr>
            <th>#</th>
            <th>Assembly</th>
            <th>Amount</th>
            <th>Current File</th>
            <th>Replace</th>
        </tr>
    </thead>

    <tbody>

        @foreach($assemblies as $index => $assembly)

            @php
                $item = $items[$assembly->id] ?? null;
                $existingAmount = $item->amount ?? 0;
                $existingFile = $item->assembly_muhtasari ?? null;
            @endphp

            <tr>

                <td>
                    {{ $index + 1 }}
                    <input type="hidden" name="assembly_ids[]" value="{{ $assembly->id }}">
                </td>

                <td>{{ $assembly->name }}</td>

                <td>
                    <input type="number"
                           name="amounts[{{ $assembly->id }}]"
                           class="amount"
                           value="{{ $existingAmount }}"
                           min="0"
                           required>
                </td>

                <td>
                    @if($existingFile)
                        <a href="{{ asset('storage/' . $existingFile) }}" target="_blank">
                            View
                        </a>
                    @else
                        No file
                    @endif
                </td>

                <td>
                    <input type="file"
                           name="assembly_muhtasari[]"
                           accept="image/*"
                           capture="environment">
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

</div>

<!-- TOTAL -->
<h3 class="total-box">
    Total: KES <span id="total">0.00</span>
</h3>

<!-- CURRENT RECEIPT -->
<p>
    <strong>Current Receipt:</strong><br>
    @if($report->receipt)
        <a href="{{ asset('storage/' . $report->receipt) }}" target="_blank">View</a>
    @else
        None
    @endif
</p>

<!-- REPLACE RECEIPT -->
<label>Replace Receipt (optional)</label>
<input type="file" name="receipt" accept="image/*" capture="environment">

<!-- SUBMIT -->
<button type="submit">
    Update Report
</button>

</form>

</div>

<!-- TOTAL SCRIPT -->
<script>
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.amount').forEach(i => {
        total += parseFloat(i.value) || 0;
    });
    document.getElementById('total').innerText = total.toFixed(2);
}

document.querySelectorAll('.amount').forEach(i =>
    i.addEventListener('input', calculateTotal)
);

calculateTotal();
</script>

@endsection