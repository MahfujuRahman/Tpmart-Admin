<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Account\Models\AccountType;
use App\Http\Controllers\Account\Models\Group;
use App\Http\Controllers\Account\Models\SubsidiaryLedger;


class ChartOfAccountsController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get all account types with their groups and subsidiary ledgers
            $search = $request->input('search');
            $query = AccountType::with(['groups' => function($query) {
                $query->where('status', 1)->orderBy('name', 'asc');
            }, 'groups.subsidiaryLedgers' => function($query) {
                $query->where('status', 1)->orderBy('name', 'asc');
            }]);

            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $accountTypes = $query->where('status', 1)
                                  ->orderBy('code', 'asc')
                                  ->get();

            if ($request->ajax()) {
                return response()->json([
                    'accountTypes' => $accountTypes
                ]);
            }

            return view('backend.accounts.chart-of-accounts.index', compact('accountTypes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading Chart of Accounts: ' . $e->getMessage());
        }
    }
}
