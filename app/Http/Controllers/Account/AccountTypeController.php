<?php
// DevMonir 07-09-2025 Account Type Controller
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Account\Models\AccountType;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    // Index with all account types for DataTable
    public function index(Request $request)
    {
        $accountTypes = AccountType::orderBy('created_at', 'desc')->get();
        return view('backend.accounts.account-type.index', compact('accountTypes'));
    }

    // Create
    public function create()
    {
        return view('backend.accounts.account-type.create');
    }

    // Store
    public function store(Request $request)
    {   
        try {   
            $request->validate([
                'account_type_name' => 'required|string|max:255|unique:account_types,name',
                'account_type_code' => 'required|string|max:60|unique:account_types,code',
                'note' => 'nullable|string|max:1000',
            ]);
            
            $accountType = AccountType::create([
                'name' => $request->account_type_name,
                'code' => $request->account_type_code,
                'note' => $request->note,
                'status' => 1
            ]);
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Account Type created successfully']);
            }
            
            return redirect()->route('account-types.index')->with('success', 'Account Type created successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Account Type creation failed: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Account Type creation failed: ' . $e->getMessage());
        }
    }

    // Edit
    public function edit($id)
    {
        try {
            $accountType = AccountType::findOrFail($id);
            
            // Return JSON for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'id' => $accountType->id,
                    'name' => $accountType->name,
                    'code' => $accountType->code,
                    'note' => $accountType->note,
                    'status' => $accountType->status
                ]);
            }
            
            return view('backend.accounts.account-type.edit', compact('accountType'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Account Type not found'], 404);
            }
            return redirect()->route('account-types.index')->with('error', 'Account Type not found');
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'account_type_name' => 'required|string|max:255|unique:account_types,name,' . $id,
                'account_type_code' => 'required|string|max:60|unique:account_types,code,' . $id,
                'note' => 'nullable|string|max:1000',
            ]);
            
            $accountType = AccountType::findOrFail($id);
            $accountType->update([
                'name' => $request->account_type_name,
                'code' => $request->account_type_code,
                'note' => $request->note,
            ]);
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Account Type updated successfully']);
            }
            
            return redirect()->route('account-types.index')->with('success', 'Account Type updated successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Account Type update failed: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Account Type update failed: ' . $e->getMessage());
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $accountType = AccountType::findOrFail($id);
            $accountType->delete();

            $message = 'Account Type deleted successfully';

            if (request()->ajax()) {
                return response()->json(['success' => $message]);
            }

            return redirect()
                ->route('account-types.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Account Type deletion failed: ' . $e->getMessage();

            if (request()->ajax()) {
                return response()->json(['error' => $message], 500);
            }

            return redirect()
                ->route('account-types.index')
                ->with('error', $message);
        }
    }

    // Toggle Status
    public function toggleStatus($id)
    {
        try {
            $accountType = AccountType::findOrFail($id);
            $accountType->update(['status' => !$accountType->status]);
            
            $status = $accountType->status ? 'activated' : 'deactivated';
            return redirect()->route('account-types.index')->with('success', "Account Type {$status} successfully");
        } catch (\Exception $e) {
            return redirect()->route('account-types.index')->with('error', 'Status update failed: ' . $e->getMessage());
        }
    }
}
