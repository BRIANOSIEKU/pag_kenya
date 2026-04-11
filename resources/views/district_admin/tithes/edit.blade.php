@extends('layouts.district_admin')

@section('content')

<h2>Edit Tithe Report</h2>

@if(session('error'))
<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:15px;">
    {{ session('error') }}
</div>
@endif

<form method="POST"
      action="{{ route('district.admin.tithes.update', $report->id) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <!-- YEAR -->
    <label>Year</label><br>
    <input type="number"
           name="year"
           value="{{ old('year', $report->year) }}"
           required>
    <br><br>

    <!-- MONTH -->
    <label>Month</label><br>
    <select name="month" required>
        @foreach([
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ] as $month)
            <option value="{{ $month }}"
                {{ old('month', $report->month) == $month ? 'selected' : '' }}>
                {{ $month }}
            </option>
        @endforeach
    </select>

    <br><br>

    <!-- PAYMENT CODE -->
    <label>Payment Code</label><br>
    <input type="text"
           name="payment_code"
           value="{{ old('payment_code', $report->payment_code) }}"
           required>

    <br><br>

    <h3>Update Assembly Contributions</h3>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px;border:1px solid #ddd;">Assembly</th>
                <th style="padding:10px;border:1px solid #ddd;">Amount (KES)</th>
            </tr>
        </thead>

        <tbody>
            @foreach($assemblies as $assembly)

                @php
                    $existingAmount = $report->items
                        ->where('assembly_id', $assembly->id)
                        ->first()
                        ->amount ?? 0;
                @endphp

                <tr>
                    <td style="padding:10px;border:1px solid #ddd;">
                        {{ $assembly->name }}
                    </td>

                    <td style="padding:10px;border:1px solid #ddd;">
                        <input type="number"
                               name="amounts[{{ $assembly->id }}]"
                               value="{{ old('amounts.' . $assembly->id, $existingAmount) }}"
                               min="0"
                               class="amount">
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    <br>

    <h3>Total: KES <span id="total">0.00</span></h3>

    <br>

    <!-- CURRENT RECEIPT -->
    <p>
        <strong>Current Receipt:</strong><br>
        @if($report->receipt)
            <a href="{{ asset('storage/' . $report->receipt) }}" target="_blank">
                View Receipt
            </a>
        @else
            No receipt uploaded
        @endif
    </p>

    <br>

    <!-- NEW RECEIPT -->
    <label>Replace Receipt (Optional)</label><br>
    <input type="file" name="receipt">

    <br><br>

    <button type="submit"
            style="background:#2196F3;color:#fff;padding:10px 15px;border:none;border-radius:5px;">
        Update Report
    </button>

</form>

<!-- AUTO TOTAL SCRIPT -->
<script>
function calculateTotal() {
    let total = 0;

    document.querySelectorAll('.amount').forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    document.getElementById('total').innerText = total.toFixed(2);
}

document.querySelectorAll('.amount').forEach(input => {
    input.addEventListener('input', calculateTotal);
});

// initial calculation on load
calculateTotal();
</script>

@endsection