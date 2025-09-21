<?php
//devMonir add 07-09-2025  12:00 PM
namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['name', 'code', 'status','created_at', 'updated_at'];
    protected $table = "account_types";

    // Relationship with Groups
    public function groups()
    {
        return $this->hasMany(Group::class, 'account_type_id');
    }
}
