<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Account\Models\SubsidiaryLedger;
use App\Http\Controllers\Account\Models\Group;
use App\Http\Controllers\Account\Models\AccountType;

class SubsidiaryLedgerController extends Controller
{
    // Index
    public function index()
    {
        try {
            $subsidiaryLedgers = SubsidiaryLedger::with(['group', 'accountType'])->orderBy('created_at', 'desc')->get();
            $groups = Group::where('status', true)->orderBy('name')->get();
            $accountTypes = AccountType::where('status', true)->orderBy('name')->get();
            return view('backend.accounts.subsidiary-ledger.index', compact('subsidiaryLedgers', 'groups', 'accountTypes'));
        } catch (\Exception $e) {
            return redirect()->route('subsidiary-ledger.index')->with('error', 'Subsidiary Ledger loading failed: ' . $e->getMessage());
        }
    }

    // Create
    public function create()
    {
        return view('backend.accounts.subsidiary-ledger.create');
    }

    // Store
    public function store(Request $request)
    {   
        try {   
            $request->validate([
                'ledger_name' => 'required|string|max:255|unique:account_subsidiary_ledgers,name',
                'ledger_code' => 'required|string|max:10|unique:account_subsidiary_ledgers,ledger_code',
                'group_id' => 'required|exists:account_groups,id',
                'account_type_id' => 'required|exists:account_types,id',
            ]); 
            
            $subsidiaryLedger = SubsidiaryLedger::create([
                'name' => $request->ledger_name,
                'ledger_code' => $request->ledger_code,
                'group_id' => $request->group_id,
                'account_type_id' => $request->account_type_id,
                'status' => 1
            ]);
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Subsidiary Ledger created successfully']);
            }
            
            return redirect()->route('subsidiary-ledger.index')->with('success', 'Subsidiary Ledger created successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Subsidiary Ledger creation failed: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Subsidiary Ledger creation failed: ' . $e->getMessage());
        }
    }

    // Edit
    public function edit($id)
    {
        try {
            $subsidiaryLedger = SubsidiaryLedger::findOrFail($id);
            
            // Return JSON for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'id' => $subsidiaryLedger->id,
                    'name' => $subsidiaryLedger->name,
                    'ledger_code' => $subsidiaryLedger->ledger_code,
                    'group_id' => $subsidiaryLedger->group_id,
                    'account_type_id' => $subsidiaryLedger->account_type_id,
                    'status' => $subsidiaryLedger->status
                ]);
            }
            
            return view('backend.accounts.subsidiary-ledger.edit', compact('subsidiaryLedger'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Subsidiary Ledger not found'], 404);
            }
            return redirect()->route('subsidiary-ledger.index')->with('error', 'Subsidiary Ledger not found');
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'ledger_name' => 'required|string|max:255|unique:account_subsidiary_ledgers,name,' . $id,
                'ledger_code' => 'required|string|max:10|unique:account_subsidiary_ledgers,ledger_code,' . $id,
                'group_id' => 'required|exists:account_groups,id',
                'account_type_id' => 'required|exists:account_types,id',
            ]);
            
            $subsidiaryLedger = SubsidiaryLedger::findOrFail($id);
            $subsidiaryLedger->update([
                'name' => $request->ledger_name,
                'ledger_code' => $request->ledger_code,
                'group_id' => $request->group_id,
                'account_type_id' => $request->account_type_id,
            ]);
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Subsidiary Ledger updated successfully']);
            }
            
            return redirect()->route('subsidiary-ledger.index')->with('success', 'Subsidiary Ledger updated successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Subsidiary Ledger update failed: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Subsidiary Ledger update failed: ' . $e->getMessage());
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $subsidiaryLedger = SubsidiaryLedger::findOrFail($id);
            
            $subsidiaryLedger->delete();

            $message = 'Subsidiary Ledger deleted successfully';

            if (request()->ajax()) {
                return response()->json(['success' => $message]);
            }

            return redirect()
                ->route('subsidiary-ledger.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Subsidiary Ledger deletion failed: ' . $e->getMessage();

            if (request()->ajax()) {
                return response()->json(['error' => $message], 500);
            }

            return redirect()
                ->route('subsidiary-ledger.index')
                ->with('error', $message);
        }
    }

    // Toggle Status
    public function toggleStatus($id)
    {
        try {
            $subsidiaryLedger = SubsidiaryLedger::findOrFail($id);
            $subsidiaryLedger->update(['status' => !$subsidiaryLedger->status]);
            
            $status = $subsidiaryLedger->status ? 'activated' : 'deactivated';
            return redirect()->route('subsidiary-ledger.index')->with('success', "Subsidiary Ledger {$status} successfully");
        } catch (\Exception $e) {
            return redirect()->route('subsidiary-ledger.index')->with('error', 'Status update failed: ' . $e->getMessage());
        }
    }

}
