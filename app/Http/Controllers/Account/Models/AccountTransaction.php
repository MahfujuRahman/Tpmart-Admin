<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Account\Models\AccountTransactionDetail;
class AccountTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['voucher_no','voucher_int_no','auto_voucher', 'status', 'amount', 'comments', 'trans_date', 'trans_type',  'created_at', 'created_by',
     'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'valid'];
    protected $table = "account_transactions";
    
    protected $casts = [
        'trans_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    
    public function accTransactionDetails()
    {
        return $this->hasMany(AccountTransactionDetail::class, 'acc_transaction_id');
    }   

}
