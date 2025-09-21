<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'account_type',
        'account_code',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Scope for active configurations
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for specific account type
    public function scopeByType($query, $type)
    {
        return $query->where('account_type', $type);
    }

    // Get all account types
    public static function getAccountTypes()
    {
        return [
            'Control Group' => 'Control Group',
            'Subsidiary Ledger' => 'Subsidiary Ledger',
            'General Ledger' => 'General Ledger'
        ];
    }
}
