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

/* ===== TABLE WRAPPER (IMPORTANT FOR MOBILE) ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px; /* prevents breaking layout */
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

/* ===== TOTAL ===== */
.total-box {
    font-size: 18px;
    font-weight: bold;
    margin-top: 10px;
    color: #333;
}

/* ===== SUBMIT BUTTON ===== */
button {
    background: #9C27B0;
    color: #fff;
    padding: 12px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {

    form {
        padding: 15px;
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
        font-size: 13px;
    }

    button {
        font-size: 16px;
    }
}
</style>

<div class="page-wrapper">

<h2>Submit Tithe Report</h2>

<form method="POST" action="{{ route('district.admin.tithes.store') }}" enctype="multipart/form-data">
@csrf

<!-- YEAR -->
<label>Year</label>
<input type="number" name="year" required>

<!-- MONTH -->
<label>Month</label>
<select name="month" required>
    @foreach([
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ] as $month)
        <option value="{{ $month }}">{{ $month }}</option>
    @endforeach
</select>

<!-- PAYMENT CODE -->
<label>Payment Code (Mpesa Transaction Code)</label>
<input type="text" name="payment_code" required>

<h3>Assemblies Tithe Entry</h3>

<!-- TABLE -->
<div class="table-container">

<table>

    <thead>
        <tr>
            <th>#</th>
            <th>Assembly</th>
            <th>Amount (KES)</th>
            <th>Muhtasari</th>
        </tr>
    </thead>

    <tbody>
        @foreach($assemblies as $index => $assembly)
        <tr>

            <td>{{ $index + 1 }}</td>

            <td>
                {{ $assembly->name }}
                <input type="hidden" name="assembly_ids[]" value="{{ $assembly->id }}">
            </td>

            <td>
                <input type="number"
                       name="amounts[{{ $assembly->id }}]"
                       class="amount"
                       value="0"
                       min="0"
                       required>
            </td>

            <td>
                <input type="file"
                       name="assembly_muhtasari[{{ $assembly->id }}]"
                       accept="image/*"
                       capture="environment"
                       required>
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

<!-- RECEIPT -->
<label>Upload Overall Receipt</label>
<input type="file" name="receipt" required>

<!-- SUBMIT -->
<button type="submit">
    Submit Report
</button>

</form>

</div>

<!-- ===== SCRIPT ===== -->
<script>
document.querySelectorAll('.amount').forEach(input => {
    input.addEventListener('input', calculateTotal);
});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.amount').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('total').innerText = total.toFixed(2);
}
</script>

@endsection