@extends('layouts.district_admin')

@section('content')

<h2>Submit Tithe Report</h2>

<form method="POST" action="{{ route('district.admin.tithes.store') }}" enctype="multipart/form-data">
@csrf

<!-- YEAR -->
<label>Year</label><br>
<input type="number" name="year" required><br><br>

<!-- MONTH -->
<label>Month</label><br>
<select name="month" required>
    @foreach([
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ] as $month)
        <option value="{{ $month }}">{{ $month }}</option>
    @endforeach
</select>

<br><br>

<!-- PAYMENT CODE -->
<label>Payment Code (Mpesa Transaction Code)</label><br>
<input type="text" name="payment_code" required placeholder="e.g. QWE123ABC">

<br><br>

<h3>Assemblies Tithe Entry</h3>

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:10px; border:1px solid #ddd;">Assembly</th>
            <th style="padding:10px; border:1px solid #ddd;">Amount (KES)</th>
        </tr>
    </thead>

    <tbody>
        @foreach($assemblies as $assembly)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">
                {{ $assembly->name }}
            </td>

            <td style="padding:10px; border:1px solid #ddd;">
                <input type="number"
                       name="amounts[{{ $assembly->id }}]"
                       class="amount"
                       value="0"
                       min="0">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<h3>Total: KES <span id="total">0.00</span></h3>

<br>

<!-- RECEIPT -->
<label>Upload Receipt / Mukhtasari</label><br>
<input type="file" name="receipt" required>

<br><br>

<button type="submit" style="background:#9C27B0;color:#fff;padding:10px 15px;border:none;border-radius:5px;">
    Submit Report
</button>

</form>

<!-- AUTO TOTAL SCRIPT -->
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