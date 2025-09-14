<?php

namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = ['name', 'code', 'account_type_id', 'note', 'status', 'created_at', 'updated_at'];
    protected $table = "account_groups";

    // Relationship with AccountType
    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    // Relationship with SubsidiaryLedgers
    public function subsidiaryLedgers()
    {
        return $this->hasMany(SubsidiaryLedger::class, 'group_id');
    }
}