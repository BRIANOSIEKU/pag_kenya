@extends('layouts.district_admin')

@section('content')

<h2>Edit Tithe Report</h2>

@if(session('error'))
<div style="background:#f8d7da;color:#721c24;padding:10px;">
    {{ session('error') }}
</div>
@endif

<form method="POST"
      action="{{ route('district.admin.tithes.update', $report->id) }}"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<label>Year</label><br>
<input type="number" name="year" value="{{ $report->year }}" required><br><br>

<label>Month</label><br>
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

<br><br>

<label>Payment Code</label><br>
<input type="text" name="payment_code" value="{{ $report->payment_code }}" required>

<br><br>

<h3>Update Assemblies</h3>

<table style="width:100%; border-collapse:collapse;">
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

                {{-- 🔥 MOBILE SAFE FILE INPUT --}}
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

<br>

<h3>Total: KES <span id="total">0.00</span></h3>

<br>

<p>
    <strong>Current Receipt:</strong><br>
    @if($report->receipt)
        <a href="{{ asset('storage/' . $report->receipt) }}" target="_blank">View</a>
    @else
        None
    @endif
</p>

<label>Replace Receipt (optional)</label><br>
<input type="file" name="receipt" accept="image/*" capture="environment">

<br><br>

<button type="submit" style="background:#2196F3;color:#fff;padding:10px;">
    Update Report
</button>

</form>

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