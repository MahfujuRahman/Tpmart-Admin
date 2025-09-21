<?php

namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_no',
        'payment_date',
        'total_amount',
        'remarks',
        'general_ledger_id',
        'payment_by',
        'subsidiary_ledger_id',
        'paid_amount',
        'note',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    // Relationship with account transactions
    public function accountTransactions()
    {
        return $this->hasMany(AccountTransaction::class, 'voucher_id');
    }

    // Scope for active vouchers
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Accessor for formatted amount
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    // Accessor for status text
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
}
