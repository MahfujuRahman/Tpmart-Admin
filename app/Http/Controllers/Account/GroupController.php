<?php
// DevMonir 07-09-2025 Group Controller
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Account\Models\Group;
use App\Http\Controllers\Account\Models\AccountType;

class GroupController extends Controller
{
    // Index
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $query = Group::with('accountType');
            
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            }
            
            $groups = $query->orderBy('created_at', 'desc')->get();
            $groups = Group::with('accountType')->orderBy('created_at', 'desc')->get();
            $accountTypes = AccountType::where('status', true)->orderBy('name')->get();
            
            if ($request->ajax()) {
                return response()->json([
                    'groups' => $groups,
                    'accountTypes' => $accountTypes
                ]);
            }
            
            return view('backend.accounts.groups.index', compact('groups', 'accountTypes'));
        } catch (\Exception $e) {
            return redirect()->route('group.index')->with('error', 'Groups loading failed: ' . $e->getMessage());
        }
    }

    // Create
    public function create()
    {
        $accountTypes = AccountType::where('status', true)->orderBy('name')->get();
        return view('backend.accounts.groups.create', compact('accountTypes'));
    }

    // Store
    public function store(Request $request)
    {   
        try {   
            // Debug: Log the request data
            \Log::info('Group Store Request:', $request->all());
            
            $request->validate([
                'group_name' => 'required|string|max:255|unique:account_groups,name',
                'group_code' => 'required|string|max:10|unique:account_groups,code',
                'account_type_id' => 'required|exists:account_types,id',
            ]); 
            
            $group = Group::create([
                'name' => $request->group_name,
                'code' => $request->group_code,
                'account_type_id' => $request->account_type_id,
                'status' => 1
            ]);
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Group created successfully']);
            }
            
            return redirect()->route('group.index')->with('success', 'Group created successfully');
        } catch (\Exception $e) {
            // Debug: Log the error
            \Log::error('Group Store Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all()
            ]);
            
            if (request()->ajax()) {
                return response()->json(['error' => 'Group creation failed: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Group creation failed: ' . $e->getMessage());
        }
    }

    // Edit
    public function edit($id)
    {
        try {
            $group = Group::findOrFail($id);
            
            if (request()->ajax()) {
                return response()->json([
                    'id' => $group->id,
                    'name' => $group->name,
                    'code' => $group->code,
                    'account_type_id' => $group->account_type_id,
                    'status' => $group->status
                ]);
            }
            
            return view('backend.accounts.groups.edit', compact('group'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Group not found'], 404);
            }
            return redirect()->route('group.index')->with('error', 'Group not found');
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'group_name' => 'required|string|max:255|unique:account_groups,name,' . $id,
                'group_code' => 'required|string|max:10|unique:account_groups,code,' . $id,
                'account_type_id' => 'required|exists:account_types,id',
            ]);
            
            $group = Group::findOrFail($id);
            $group->update([
                'name' => $request->group_name,
                'code' => $request->group_code,
                'account_type_id' => $request->account_type_id,
            ]);
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Group updated successfully']);
            }
            
            return redirect()->route('group.index')->with('success', 'Group updated successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Group update failed: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Group update failed: ' . $e->getMessage());
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $group = Group::findOrFail($id);

            $group->delete();

            $message = 'Group deleted successfully';

            if (request()->ajax()) {
                return response()->json(['success' => $message]);
            }

            return redirect()
                ->route('group.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Group deletion failed: ' . $e->getMessage();

            if (request()->ajax()) {
                return response()->json(['error' => $message], 500);
            }

            return redirect()
                ->route('group.index')
                ->with('error', $message);
        }
    }

    // Toggle Status
    public function toggleStatus($id)
    {
        try {
            $group = Group::findOrFail($id);
            $group->update(['status' => !$group->status]);
            
            $status = $group->status ? 'activated' : 'deactivated';
            return redirect()->route('group.index')->with('success', "Group {$status} successfully");
        } catch (\Exception $e) {
            return redirect()->route('group.index')->with('error', 'Status update failed: ' . $e->getMessage());
        }
    }
}
