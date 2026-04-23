@extends('layouts.admin')

@section('content')

<div class="container">

    {{-- BACK BUTTON --}}
    <div style="margin-bottom:15px;">
        <a href="{{ route('admin.departments.index') }}"
           style="display:inline-block; padding:8px 12px; background:#607D8B; color:#fff; border-radius:6px; text-decoration:none;">
            ← Back to Departments
        </a>
    </div>

    {{-- TITLE --}}
    <h2 style="margin-bottom:10px;">
        {{ optional($department)->name ?? 'Department' }} - Finance Dashboard
    </h2>

    {{-- ================= CURRENT PERIOD ================= --}}
    <div style="margin-bottom:15px; background:#1e3c72; color:#fff; padding:10px; border-radius:6px;">
        📅 Current Period:
        <strong>
            {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
        </strong>

        @if($isClosed ?? false)
            <span style="margin-left:10px; background:#d32f2f; padding:4px 8px; border-radius:4px;">
                🔒 CLOSED
            </span>
        @else
            <span style="margin-left:10px; background:#4CAF50; padding:4px 8px; border-radius:4px;">
                OPEN
            </span>
        @endif
    </div>

    {{-- ================= FILTER ================= --}}
    <form method="GET" style="margin-bottom:15px; display:flex; gap:10px; align-items:center;">

        <select name="month" onchange="this.form.submit()" style="padding:8px;">
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endfor
        </select>

        <select name="year" onchange="this.form.submit()" style="padding:8px;">
            @for($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

    </form>

    {{-- ================= EXPORT REPORT SECTION ================= --}}
    <div style="margin-bottom:20px; background:#f0f4ff; padding:12px; border-radius:8px;">

        <h4 style="margin-bottom:10px;">📄 Export Reports</h4>

        <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">

            <form method="GET" action="{{ route('admin.departments.finance.export.monthly', $department->id) }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <button type="submit"
                    style="background:#1e3c72; color:#fff; padding:8px 12px; border:none; border-radius:6px;">
                    ⬇ Export Monthly Report (PDF)
                </button>
            </form>

            <form method="GET" action="{{ route('admin.departments.finance.export.yearly', $department->id) }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <button type="submit"
                    style="background:#e53935; color:#fff; padding:8px 12px; border:none; border-radius:6px;">
                    📉 Export Yearly Statement (PDF)
                </button>
            </form>

        </div>
    </div>

    {{-- ================= OPENING BALANCE ================= --}}
    <div style="margin-bottom:15px; background:#f5f5f5; padding:10px; border-radius:8px;">
        <strong>Opening Balance:</strong>
        KES {{ number_format($openingBalance ?? 0, 2) }}
    </div>

    {{-- ================= SUMMARY ================= --}}
    @php
        $safeBalance = $balance ?? (($openingBalance ?? 0) + ($income ?? 0) - ($expense ?? 0));
    @endphp

    <div style="display:flex; gap:15px; flex-wrap:wrap; margin-bottom:20px;">

        <div style="flex:1; min-width:200px; background:#4CAF50; color:#fff; padding:15px; border-radius:8px;">
            <h4>Total Income</h4>
            <p>KES {{ number_format($income ?? 0, 2) }}</p>
        </div>

        <div style="flex:1; min-width:200px; background:#e53935; color:#fff; padding:15px; border-radius:8px;">
            <h4>Total Expense</h4>
            <p>KES {{ number_format($expense ?? 0, 2) }}</p>
        </div>

        <div style="flex:1; min-width:200px; background:#1e3c72; color:#fff; padding:15px; border-radius:8px;">
            <h4>Closing Balance</h4>
            <p>KES {{ number_format($safeBalance, 2) }}</p>
        </div>

    </div>

    {{-- ================= ACTION BUTTONS ================= --}}
    <div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

        @if(!($isClosed ?? false))

            <button type="button"
                onclick="openIncomeModal()"
                style="padding:8px 12px; background:#2196F3; color:#fff; border-radius:6px; border:none; cursor:pointer;">
                + Add Income
            </button>

            <button type="button"
                onclick="openExpenseModal()"
                style="padding:8px 12px; background:#FF9800; color:#fff; border-radius:6px; border:none; cursor:pointer;">
                + Add Expense
            </button>

            <form method="POST"
                  action="{{ route('admin.departments.finance.closeMonth', $department->id) }}">
                @csrf
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <button type="submit"
                    onclick="return confirm('Are you sure you want to close this month?')"
                    style="padding:8px 12px; background:#d32f2f; color:#fff; border-radius:6px; border:none; cursor:pointer;">
                    🔒 Close Month
                </button>
            </form>

        @else
            <div style="color:#d32f2f; font-weight:bold;">
                This month is locked. No edits allowed.
            </div>
        @endif

    </div>

    {{-- ================= TABLE ================= --}}
    <div style="background:#fff; padding:15px; border-radius:8px; overflow-x:auto;">

        <table style="width:100%; border-collapse:collapse;">

            <thead>
                <tr style="background:#1e3c72; color:#fff;">
                    <th style="padding:10px;">Date</th>
                    <th style="padding:10px;">Type</th>
                    <th style="padding:10px;">Title</th>
                    <th style="padding:10px;">Payment Mode</th>
                    <th style="padding:10px;">Bank / Mpesa</th>
                    <th style="padding:10px;">Account</th>
                    <th style="padding:10px;">Amount</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions ?? [] as $t)
                    <tr>
                        <td style="padding:10px;">{{ $t->transaction_date }}</td>
                        <td style="padding:10px;">{{ ucfirst($t->type) }}</td>
                        <td style="padding:10px;">{{ $t->title }}</td>
                        <td style="padding:10px;">{{ ucfirst($t->payment_mode ?? '-') }}</td>
                        <td style="padding:10px;">{{ $t->bank_name ?? 'Mpesa' }}</td>
                        <td style="padding:10px;">{{ $t->account_reference ?? '-' }}</td>
                        <td style="padding:10px;">KES {{ number_format($t->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">No transactions for this period</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

{{-- ================= INCOME MODAL ================= --}}
<div id="incomeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:999;">
    <div style="background:#fff; width:400px; margin:10% auto; padding:20px; border-radius:8px;">
        <h3>Add Income</h3>

        <form method="POST" action="{{ route('admin.departments.finance.store', $department->id) }}">
            @csrf

            {{-- ✅ IMPORTANT --}}
            <input type="hidden" name="department_id" value="{{ $department->id }}">
            <input type="hidden" name="type" value="income">

            <input name="title" placeholder="Title" required style="width:100%; padding:8px; margin-bottom:10px;">
            <input name="amount" type="number" step="0.01" placeholder="Amount" required style="width:100%; padding:8px; margin-bottom:10px;">
            <input name="transaction_date" type="date" required style="width:100%; padding:8px; margin-bottom:10px;">

            <select name="payment_mode" style="width:100%; padding:8px; margin-bottom:10px;">
                <option value="mpesa">Mpesa</option>
                <option value="bank">Bank</option>
                <option value="cash">Cash</option>
            </select>

            <input name="bank_name" placeholder="Bank Name" style="width:100%; padding:8px; margin-bottom:10px;">
            <input name="account_reference" placeholder="Reference" style="width:100%; padding:8px; margin-bottom:10px;">

            <button type="submit" style="width:100%; background:#2196F3; color:#fff; padding:10px; border:none;">
                Save Income
            </button>
        </form>

        <button onclick="closeIncomeModal()" style="margin-top:10px; width:100%;">Close</button>
    </div>
</div>

{{-- ================= EXPENSE MODAL ================= --}}
<div id="expenseModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:999;">
    <div style="background:#fff; width:400px; margin:10% auto; padding:20px; border-radius:8px;">
        <h3>Add Expense</h3>

        <form method="POST" action="{{ route('admin.departments.finance.store', $department->id) }}">
            @csrf

            {{-- ✅ IMPORTANT --}}
            <input type="hidden" name="department_id" value="{{ $department->id }}">
            <input type="hidden" name="type" value="expense">

            <input name="title" placeholder="Title" required style="width:100%; padding:8px; margin-bottom:10px;">
            <input name="amount" type="number" step="0.01" placeholder="Amount" required style="width:100%; padding:8px; margin-bottom:10px;">
            <input name="transaction_date" type="date" required style="width:100%; padding:8px; margin-bottom:10px;">

            <select name="payment_mode" style="width:100%; padding:8px; margin-bottom:10px;">
                <option value="mpesa">Mpesa</option>
                <option value="bank">Bank</option>
                <option value="cash">Cash</option>
            </select>

            <input name="bank_name" placeholder="Bank Name" style="width:100%; padding:8px; margin-bottom:10px;">
            <input name="account_reference" placeholder="Reference" style="width:100%; padding:8px; margin-bottom:10px;">

            <button type="submit" style="width:100%; background:#FF9800; color:#fff; padding:10px; border:none;">
                Save Expense
            </button>
        </form>

        <button onclick="closeExpenseModal()" style="margin-top:10px; width:100%;">Close</button>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script>
function openIncomeModal() {
    document.getElementById('incomeModal').style.display = 'block';
}
function closeIncomeModal() {
    document.getElementById('incomeModal').style.display = 'none';
}
function openExpenseModal() {
    document.getElementById('expenseModal').style.display = 'block';
}
function closeExpenseModal() {
    document.getElementById('expenseModal').style.display = 'none';
}
</script>

@endsection