<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DepartmentFinance;
use App\Models\DepartmentFinanceClosure;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'overview',
        'leadership',
        'activities',
        'description',
        'photo',
    ];

    /**
     * ================= ROUTE MODEL BINDING =================
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * ================= BASIC RELATIONSHIPS =================
     */
    public function documents()
    {
        return $this->hasMany(DepartmentDocument::class);
    }

    public function achievements()
    {
        return $this->hasMany(DepartmentAchievement::class)->latest();
    }

    public function galleryImages()
    {
        return $this->hasMany(DepartmentGallery::class)->latest();
    }

    public function otherLeaders()
    {
        return $this->hasMany(OtherLeader::class)->orderBy('id');
    }

    public function upcomingEvents()
    {
        return $this->hasMany(DepartmentUpcomingEvent::class)
            ->orderBy('event_date', 'asc');
    }

    /**
     * ================= FINANCE TRANSACTIONS =================
     */
    public function finances()
    {
        return $this->hasMany(DepartmentFinance::class);
    }

    /**
     * ================= FINANCE CLOSURES =================
     */
    public function financeClosures()
    {
        return $this->hasMany(DepartmentFinanceClosure::class);
    }

    /**
     * ================= MONTHLY FINANCE HELPERS =================
     */

    // Total income
    public function getTotalIncomeAttribute()
    {
        return $this->finances()
            ->where('type', 'income')
            ->sum('amount') ?? 0;
    }

    // Total expense
    public function getTotalExpenseAttribute()
    {
        return $this->finances()
            ->where('type', 'expense')
            ->sum('amount') ?? 0;
    }

    // Current balance (ALL TIME)
    public function getBalanceAttribute()
    {
        return ($this->total_income ?? 0) - ($this->total_expense ?? 0);
    }

    /**
     * ================= MONTHLY OPENING BALANCE =================
     */
    public function getOpeningBalance($month, $year)
    {
        $previous = $this->financeClosures()
            ->where(function ($q) use ($month, $year) {

                // previous month logic
                if ($month == 1) {
                    $q->where('month', 12)->where('year', $year - 1);
                } else {
                    $q->where('month', $month - 1)->where('year', $year);
                }
            })
            ->first();

        return $previous->closing_balance ?? 0;
    }

    /**
     * ================= CURRENT MONTH BALANCE =================
     */
    public function getMonthlyBalance($month, $year)
    {
        $transactions = $this->finances()
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->get();

        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        return $income - $expense;
    }

    /**
     * ================= ROUTE SAFETY =================
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->firstOrFail();
    }
}