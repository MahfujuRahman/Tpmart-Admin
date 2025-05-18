<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Account\Models\AcAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function addNewAcAccount()
    {
        $accounts = AcAccount::where('status', 'active')->get();
        // $users = User::where('status', 1)->get();
        // return view('backend.account.create', compact('customer_categories', 'customer_source_types', 'users'));
        return view('backend.account.create', compact('accounts'));
    }

    public function saveNewAcAccount(Request $request)
    {
        // dd(request()->all());
        $request->validate([
            'account_name' => ['required', 'string', 'max:100'],
            'account_code' => ['required', 'string', 'max:100'],
        ], [
            'account_name.required' => 'account name is required.',
            'account_name.max' => 'account name must not exceed 100 characters.',
            'account_code.required' => 'account code is required.',
            'account_code.max' => 'account code must not exceed 100 characters.',
        ]);

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower(request()->account_name)); //remove all non alpha numeric
        $slug = preg_replace('!\s+!', '-', $clean);

        $lastCountId = AcAccount::max('count_id') ?? 0;
        $countId = $lastCountId + 1;

        // $customer_category = CustomerCategory::where('id', request()->customer_category_id)->first();
        // $customer_source_type = CustomerSourceType::where('id', request()->customer_source_type_id)->first();
        // dd(5);

        AcAccount::insert([
            'store_id' => 1,
            'count_id' => $countId,
            'parent_id' => request()->parent_id ?? '',
            'account_name' => request()->account_name ?? '',
            'account_code' => request()->account_code ?? '',
            'sort_code' => request()->account_code ?? '',
            'balance' => 0.0000,
            'note' => request()->note ?? '',

            'creator' => auth()->user()->id,
            'slug' => $slug . time(),
            'status' => 'active',
            'created_at' => Carbon::now('Asia/Dhaka')
        ]);

        Toastr::success('Added successfully!', 'Success');
        return back();

    }


    public function viewAllAcAccount(Request $request)
    {
        if ($request->ajax()) {
            $data = AcAccount::with('user')
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    return $data->user ? $data->user->name : 'N/A';
                })
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i", strtotime($data->created_at));
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a href="' . url('edit/ac-account') . '/' . $data->slug . '" class="btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.account.view');
    }


    public function editAcAccount($slug)
    {
        $data = AcAccount::where('status', 'active')->where('slug', $slug)->first();
        $accounts = AcAccount::where('status', 'active')->get();
        return view('backend.account.edit', compact('data', 'accounts'));
    }

    public function updateAcAccount(Request $request)
    {
        // dd(request()->all());
        $request->validate([
            'account_name' => ['required', 'string', 'max:100'],
            'account_code' => ['required', 'string', 'max:100'],
        ], [
            'account_name.required' => 'account name is required.',
            'account_name.max' => 'account name must not exceed 100 characters.',
            'account_code.required' => 'account code is required.',
            'account_code.max' => 'account code must not exceed 100 characters.',
        ]);

        // Check if the selected product_warehouse_room_id exists for the selected product_warehouse_id        
        $data = AcAccount::where('id', request()->account_id)->first();

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($data->account_name)); //remove all non alpha numeric
        $slug = preg_replace('!\s+!', '-', $clean);

        $data->store_id = request()->store_id ?? $data->store_id;
        $data->parent_id = request()->parent_id ?? $data->parent_id;
        $data->account_name = request()->account_name ?? $data->account_name;
        $data->account_code = request()->account_code ?? $data->account_code;
        $data->sort_code = request()->account_code ?? $data->sort_code;
        $data->balance = 0.0000;
        $data->note = request()->note ?? $data->note;


        if ($data->account_name != $request->account_name) {
            $data->slug = $slug . time();
        }

        $data->creator = auth()->user()->id;
        $data->status = request()->status ?? $data->status;
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();

        Toastr::success('Successfully Updated', 'Success!');
        return redirect()->route('ViewAllAcAccount');
    }


    public function deleteAcAccount($slug)
    {
        $data = AcAccount::where('slug', $slug)->first();

        $data->delete();
        // $data->status = 'inactive';
        // $data->save();

        return response()->json([
            'success' => 'Deleted successfully!',
            'data' => 1
        ]);
    }


    private function buildTree($accounts, $parentId = null)
    {
        $tree = [];

        foreach ($accounts as $account) {
            if ($account->parent_id == $parentId) {
                $children = $this->buildTree($accounts, $account->id);
                $node = [
                    'id' => $account->id,
                    'text' => $account->account_name,
                ];

                if (!empty($children)) {
                    $node['inc'] = $children;
                }

                $tree[] = $node;
            }
        }

        return $tree;
    }


    public function getJsonAcAccount()
    {
        $accounts = AcAccount::where('status', 'active')
                                ->where('account_name', '!=', 'Expense')
                                ->get();
        $nestedData = $this->buildTree($accounts);
        // dd($nestedData);
        return response()->json($nestedData);
    }





























    public function getJsonAcAccountExpense()
    {
        // Find the ID of the 'Expense' account
        $accounts = AcAccount::where('account_name', 'Expense')->with('inc')->where('status', 'active')->get();

        return response()->json($accounts);
        // return $accounts;
        // dd($accounts->toArray());
        // If the 'Expense' account doesn't exist, return an empty response
        // if (!$accounts) {
        //     return response()->json([]);
        // }

        // $nestedData = $this->buildTreeExpense($accounts);

        // dd($nestedData);

        // return response()->json($nestedData);
    }






}
