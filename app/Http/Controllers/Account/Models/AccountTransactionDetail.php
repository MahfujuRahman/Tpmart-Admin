<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Account\Models\AccountTransaction;
class AccountTransactionDetail extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $fillable = [
        'acc_transaction_id',
        'dr_adjust_trans_id',
        'dr_adjust_voucher_no',
        'dr_adjust_voucher_date',
        'cr_adjust_trans_id',
        'cr_adjust_voucher_no',
        'cr_adjust_voucher_date',
        'dr_gl_ledger',
        'dr_sub_ledger',
        'cr_gl_ledger',
        'cr_sub_ledger',
        'ref_sub_ledger',
        'amount',
        'created_by',
        'updated_by',
        'deleted_by',
        'valid'
    ];

    protected $table = "account_transaction_details";

    public function accountTransaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'acc_transaction_id');
    }

    public function drAdjustTransaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'dr_adjust_trans_id');
    }
    
    public function crAdjustTransaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'cr_adjust_trans_id');
    }
    
    
    public function drGlLedger()
    {
        return $this->belongsTo(SubsidiaryLedger::class, 'dr_gl_ledger');
    }
    
    public function crGlLedger()
    {
        return $this->belongsTo(SubsidiaryLedger::class, 'cr_gl_ledger');
    }
    
    
    public function drSubLedger()
    {
        return $this->belongsTo(SubsidiaryLedger::class, 'dr_sub_ledger');
    }
    
    
    
    public function crSubLedger()
    {
        return $this->belongsTo(SubsidiaryLedger::class, 'cr_sub_ledger');
    }
    
    
    
}
