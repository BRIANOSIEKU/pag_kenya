<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class DepartmentFinance extends Model
{
    use HasFactory;

    /**
     * ================= TABLE =================
     * Ensures Laravel uses correct table name
     */
    protected $table = 'department_finances';

    /**
     * ================= MASS ASSIGNMENT =================
     */
protected $fillable = [
    'department_id',
    'title',
    'type',
    'amount',
    'transaction_date',
    'payment_mode',
    'bank_name',
    'account_reference',
];

    /**
     * ================= RELATIONSHIP =================
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * ================= SCOPES (CLEAN QUERIES) =================
     */

    // Income only
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    // Expense only
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    // Current month filter (optional but useful)
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('transaction_date', now()->month)
                     ->whereYear('transaction_date', now()->year);
    }
}