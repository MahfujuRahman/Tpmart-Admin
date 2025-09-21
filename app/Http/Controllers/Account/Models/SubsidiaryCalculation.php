<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsidiaryCalculation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['particular', 'particular_control_group', 'particular_sub_ledger_group_id', 'trans_date', 'sub_ledger', 
	'gl_ledger', 'nature_id', 'debit_amount', 'credit_amount', 'transaction_type', 'transaction_id', 'tran_details_id', 'adjust_trans_id', 
	'adjust_vouchar_date', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'valid'];
    protected $table = "subsidiary_calculations";

    public function subsidiaryLedger()
    {
        return $this->belongsTo(SubsidiaryLedger::class);
    }
}

