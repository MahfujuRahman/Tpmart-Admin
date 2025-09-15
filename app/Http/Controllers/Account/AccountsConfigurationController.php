<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Account\Models\AccountsConfiguration;
use Illuminate\Support\Facades\DB;

class AccountsConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configurations = AccountsConfiguration::orderBy('sort_order')->get();
        return view('backend.accounts.configuration.index', compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accountTypes = AccountsConfiguration::getAccountTypes();
        return view('backend.accounts.configuration.create', compact('accountTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|in:Control Group,Subsidiary Ledger,General Ledger',
            'account_code' => 'required|string|max:20|unique:accounts_configurations,account_code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        try {
            AccountsConfiguration::create([
                'account_name' => $request->account_name,
                'account_type' => $request->account_type,
                'account_code' => $request->account_code,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0
            ]);

            return redirect()->route('accounts-configuration.index')
                ->with('success', 'Account configuration created successfully!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating account configuration: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountsConfiguration $accountsConfiguration)
    {
        return view('backend.accounts.configuration.show', compact('accountsConfiguration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountsConfiguration $accountsConfiguration)
    {
        $accountTypes = AccountsConfiguration::getAccountTypes();
        return view('backend.accounts.configuration.edit', compact('accountsConfiguration', 'accountTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountsConfiguration $accountsConfiguration)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|in:Control Group,Subsidiary Ledger,General Ledger',
            'account_code' => 'required|string|max:20|unique:accounts_configurations,account_code,' . $accountsConfiguration->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        try {
            $accountsConfiguration->update([
                'account_name' => $request->account_name,
                'account_type' => $request->account_type,
                'account_code' => $request->account_code,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0
            ]);

            return redirect()->route('accounts-configuration.index')
                ->with('success', 'Account configuration updated successfully!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating account configuration: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountsConfiguration $accountsConfiguration)
    {
        try {
            $accountsConfiguration->delete();
            return redirect()->route('accounts-configuration.index')
                ->with('success', 'Account configuration deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting account configuration: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update configurations
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'configurations' => 'required|array',
            'configurations.*.id' => 'required|exists:accounts_configurations,id',
            'configurations.*.account_code' => 'required|string|max:20'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->configurations as $config) {
                AccountsConfiguration::where('id', $config['id'])
                    ->update(['account_code' => $config['account_code']]);
            }

            DB::commit();

            return redirect()->route('accounts-configuration.index')
                ->with('success', 'Account configurations updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating configurations: ' . $e->getMessage());
        }
    }

    /**
     * Reset to default configurations
     */
    public function resetToDefault()
    {
        try {
            DB::beginTransaction();

            // Clear existing configurations
            AccountsConfiguration::truncate();

            // Insert default configurations
            $defaultConfigs = [
                ['account_name' => 'Cash', 'account_type' => 'Control Group', 'account_code' => '1201000000', 'sort_order' => 1],
                ['account_name' => 'Retained Surplus', 'account_type' => 'Subsidiary Ledger', 'account_code' => '2101001001', 'sort_order' => 2],
                ['account_name' => 'Cash in Hand', 'account_type' => 'General Ledger', 'account_code' => '1201001000', 'sort_order' => 3],
                ['account_name' => 'Cash at Bank', 'account_type' => 'General Ledger', 'account_code' => '1201002000', 'sort_order' => 4],
                ['account_name' => 'Advance', 'account_type' => 'Control Group', 'account_code' => '1301000000', 'sort_order' => 5],
                ['account_name' => 'Receivable', 'account_type' => 'Control Group', 'account_code' => '1401000000', 'sort_order' => 6],
                ['account_name' => 'Payable', 'account_type' => 'Control Group', 'account_code' => '2001000000', 'sort_order' => 7],
                ['account_name' => 'Sales', 'account_type' => 'Control Group', 'account_code' => '3001000000', 'sort_order' => 8],
                ['account_name' => 'Goods Sales', 'account_type' => 'General Ledger', 'account_code' => '3001001000', 'sort_order' => 9],
                ['account_name' => 'Wages Sales', 'account_type' => 'General Ledger', 'account_code' => '3001002000', 'sort_order' => 10],
                ['account_name' => 'Sales Return', 'account_type' => 'Control Group', 'account_code' => '3101000000', 'sort_order' => 11],
                ['account_name' => 'Sales Return- Goods', 'account_type' => 'General Ledger', 'account_code' => '3101001000', 'sort_order' => 12],
                ['account_name' => 'Sales Return-Wages', 'account_type' => 'General Ledger', 'account_code' => '3101002000', 'sort_order' => 13],
                ['account_name' => 'Cost of Goods Sold', 'account_type' => 'Control Group', 'account_code' => '4001000000', 'sort_order' => 14],
                ['account_name' => 'Inventory Stock', 'account_type' => 'Control Group', 'account_code' => '1501000000', 'sort_order' => 15],
                ['account_name' => 'Raw Materials', 'account_type' => 'Subsidiary Ledger', 'account_code' => '1501001001', 'sort_order' => 16],
                ['account_name' => 'Work-in-Progress', 'account_type' => 'Subsidiary Ledger', 'account_code' => '1501001002', 'sort_order' => 17],
                ['account_name' => 'Finished Goods', 'account_type' => 'Subsidiary Ledger', 'account_code' => '1501001003', 'sort_order' => 18],
                ['account_name' => 'Materials Purchase', 'account_type' => 'General Ledger', 'account_code' => '4001001000', 'sort_order' => 19],
                ['account_name' => 'Purchase Return', 'account_type' => 'Control Group', 'account_code' => '4101000000', 'sort_order' => 20],
                ['account_name' => 'Fixed Assets', 'account_type' => 'Control Group', 'account_code' => '1101000000', 'sort_order' => 21]
            ];

            foreach ($defaultConfigs as $config) {
                AccountsConfiguration::create($config);
            }

            DB::commit();

            return redirect()->route('accounts-configuration.index')
                ->with('success', 'Account configurations reset to default successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error resetting configurations: ' . $e->getMessage());
        }
    }
}