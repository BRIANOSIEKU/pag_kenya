<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentFinance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DepartmentFinanceReportController extends Controller
{
    /**
     * =========================
     * OPENING BALANCE (SAME LOGIC AS MAIN CONTROLLER)
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
     * INDEX (REPORT DASHBOARD)
     * =========================
     */
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.finance_reports', compact('departments'));
    }

    /**
     * =========================
     * MONTHLY REPORT PDF
     * =========================
     */
    public function monthly(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        $department = Department::findOrFail($request->department_id);

        $transactions = DepartmentFinance::where('department_id', $department->id)
            ->whereYear('transaction_date', $request->year)
            ->whereMonth('transaction_date', $request->month)
            ->orderBy('transaction_date', 'asc')
            ->get();

        $income  = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        $openingBalance = $this->getOpeningBalance(
            $department->id,
            $request->month,
            $request->year
        );

        $closingBalance = ($openingBalance + $income) - $expense;

        $pdf = Pdf::loadView('admin.departments.pdf.monthly', [
            'department' => $department,
            'transactions' => $transactions,
            'income' => $income,
            'expense' => $expense,
            'openingBalance' => $openingBalance,
            'closingBalance' => $closingBalance,
            'month' => $request->month,
            'year' => $request->year
        ]);

        return $pdf->download($department->name . "_Monthly_Report.pdf");
    }

    /**
     * =========================
     * YEARLY REPORT PDF (FIXED + CLEAN)
     * =========================
     */
    public function yearly(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'year' => 'required'
        ]);

        $department = Department::findOrFail($request->department_id);

        $data = [];
        $previousClosing = 0;

        for ($month = 1; $month <= 12; $month++) {

            $transactions = DepartmentFinance::where('department_id', $department->id)
                ->whereYear('transaction_date', $request->year)
                ->whereMonth('transaction_date', $month)
                ->get();

            $income  = $transactions->where('type', 'income')->sum('amount');
            $expense = $transactions->where('type', 'expense')->sum('amount');

            $opening = $previousClosing;
            $closing = ($opening + $income) - $expense;

            $data[] = [
                'month' => $month,
                'opening' => $opening,
                'income' => $income,
                'expense' => $expense,
                'closing' => $closing
            ];

            $previousClosing = $closing;
        }

        $grandBalance = $previousClosing;

        $pdf = Pdf::loadView('admin.departments.pdf.yearly', [
            'department' => $department,
            'data' => $data,
            'year' => $request->year,
            'grandBalance' => $grandBalance
        ]);

        return $pdf->download($department->name . "_Yearly_Report.pdf");
    }
}