<?php

namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsidiaryLedger extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = ['name', 'ledger_code', 'group_id', 'account_type_id', 'status', 'created_at', 'updated_at'];
    protected $table = "account_subsidiary_ledgers";

    // Relationship with Group
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // Relationship with AccountType
    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }
}
