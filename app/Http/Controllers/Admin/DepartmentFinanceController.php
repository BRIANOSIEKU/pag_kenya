<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentFinance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class DepartmentFinanceController extends Controller
{
    /**
     * =========================
     * OPENING BALANCE
     * =========================
     */
    private function getOpeningBalance($departmentId, $month, $year)
    {
        $prevMonth = $month - 1;
        $prevYear  = $year;

        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear--;
        }

        $previous = DB::table('department_finance_closures')
            ->where('department_id', $departmentId)
            ->where('month', $prevMonth)
            ->where('year', $prevYear)
            ->first();

        return $previous->closing_balance ?? 0;
    }

    /**
     * =========================
     * DASHBOARD
     * =========================
     */
    public function dashboard(Request $request, Department $department)
    {
        $month = (int) ($request->month ?? now()->month);
        $year  = (int) ($request->year ?? now()->year);

        $closure = DB::table('department_finance_closures')
            ->where('department_id', $department->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        $isClosed = $closure->is_closed ?? 0;

        $openingBalance = $closure->opening_balance
            ?? $this->getOpeningBalance($department->id, $month, $year);

        $transactions = DepartmentFinance::where('department_id', $department->id)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date', 'asc')
            ->get();

        $income  = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        $closingBalance = ($openingBalance + $income) - $expense;

        return view('admin.departments.finance.dashboard', compact(
            'department',
            'transactions',
            'income',
            'expense',
            'openingBalance',
            'closingBalance',
            'month',
            'year',
            'isClosed'
        ));
    }
public function store(Request $request, Department $department)
{
    $date  = Carbon::parse($request->transaction_date);
    $month = $date->month;
    $year  = $date->year;

    $isClosed = DB::table('department_finance_closures')
        ->where('department_id', $department->id)
        ->where('month', $month)
        ->where('year', $year)
        ->where('is_closed', 1)
        ->exists();

    if ($isClosed) {
        return back()->with('error', 'This month is closed.');
    }

    $request->validate([
        'type' => 'required|in:income,expense',
        'title' => 'nullable|string|max:255',
        'amount' => 'required|numeric|min:0',
        'transaction_date' => 'required|date',
        'payment_mode' => 'nullable|string|max:255',
        'bank_name' => 'nullable|string|max:255',
        'account_reference' => 'nullable|string|max:255',
    ]);

    DepartmentFinance::create([
        'department_id' => $department->id,
        'type' => $request->type,
        'title' => $request->title,
        'amount' => $request->amount,
        'transaction_date' => $request->transaction_date,
        'payment_mode' => $request->payment_mode,
        'bank_name' => $request->bank_name,
        'account_reference' => $request->account_reference,
    ]);

    return back()->with('success', 'Transaction added successfully.');
}
    /**
     * =========================
     * CLOSE MONTH
     * =========================
     */
    public function closeMonth(Request $request, Department $department)
    {
        $month = (int) $request->month;
        $year  = (int) $request->year;

        $transactions = DepartmentFinance::where('department_id', $department->id)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->get();

        $income  = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        $openingBalance = $this->getOpeningBalance($department->id, $month, $year);
        $closingBalance = ($openingBalance + $income) - $expense;

        DB::table('department_finance_closures')->updateOrInsert(
            [
                'department_id' => $department->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'opening_balance' => $openingBalance,
                'income' => $income,
                'expense' => $expense,
                'closing_balance' => $closingBalance,
                'is_closed' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return back()->with('success', 'Month closed successfully.');
    }

    /**
     * =========================
     * EXPORT MONTHLY PDF
     * =========================
     */
    public function exportMonthly(Request $request, Department $department)
    {
        $month = (int) $request->month;
        $year  = (int) $request->year;

        $transactions = DepartmentFinance::where('department_id', $department->id)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date', 'asc')
            ->get();

        $income  = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        $openingBalance = $this->getOpeningBalance($department->id, $month, $year);
        $closingBalance = ($openingBalance + $income) - $expense;

        $pdf = PDF::loadView('admin.departments.finance.pdf.monthly', compact(
            'department',
            'transactions',
            'income',
            'expense',
            'openingBalance',
            'closingBalance',
            'month',
            'year'
        ));

        return $pdf->download($department->name . "_Monthly_Report_{$month}_{$year}.pdf");
    }

    /**
     * =========================
     * EXPORT YEARLY SUMMARY PDF
     * =========================
     */
    public function exportYearlySummary(Request $request, Department $department)
    {
        $year = (int) $request->year;

        $data = [];
        $previousClosing = 0;

        for ($month = 1; $month <= 12; $month++) {

            $transactions = DepartmentFinance::where('department_id', $department->id)
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $month)
                ->get();

            $income  = $transactions->where('type', 'income')->sum('amount');
            $expense = $transactions->where('type', 'expense')->sum('amount');

            $openingBalance = $previousClosing;
            $closingBalance = ($openingBalance + $income) - $expense;

            $data[] = [
                'month' => $month,
                'opening' => $openingBalance,
                'income' => $income,
                'expense' => $expense,
                'closing' => $closingBalance,
            ];

            $previousClosing = $closingBalance;
        }

        $grandBalance = $previousClosing;

        $pdf = PDF::loadView('admin.departments.finance.pdf.yearly', compact(
            'department',
            'data',
            'year',
            'grandBalance'
        ));

        return $pdf->download($department->name . "_Yearly_Report_{$year}.pdf");
    }

    /**
     * =========================
     * MONTHLY VIEW REPORT
     * =========================
     */
    public function monthlyReport(Department $department, $year, $month)
    {
        $transactions = DepartmentFinance::where('department_id', $department->id)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->get();

        $income  = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        $openingBalance = $this->getOpeningBalance($department->id, $month, $year);
        $closingBalance = ($openingBalance + $income) - $expense;

        return view('admin.departments.finance.report', compact(
            'department',
            'transactions',
            'income',
            'expense',
            'openingBalance',
            'closingBalance',
            'month',
            'year'
        ));
    }
}