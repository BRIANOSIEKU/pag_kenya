@extends('layouts.district_admin')

@section('content')

<h2>Submit Tithe Report</h2>

<form method="POST" action="{{ route('district.admin.tithes.store') }}" enctype="multipart/form-data">
@csrf

<label>Year</label><br>
<input type="number" name="year" required><br><br>

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

<label>Payment Code (Mpesa Transaction Code)</label><br>
<input type="text" name="payment_code" required>

<br><br>

<h3>Assemblies Tithe Entry</h3>

<table style="width:100%; border-collapse:collapse;">
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

<br>

<h3>Total: KES <span id="total">0.00</span></h3>

<br>

<label>Upload Overall Receipt</label><br>
<input type="file" name="receipt" required>

<br><br>

<button type="submit" style="background:#9C27B0;color:#fff;padding:10px 15px;border:none;">
    Submit Report
</button>

</form>

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