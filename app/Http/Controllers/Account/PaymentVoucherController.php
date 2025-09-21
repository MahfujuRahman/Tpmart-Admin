<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Account\Models\AccountTransaction;
use App\Http\Controllers\Account\Models\AccountTransactionDetail;
use App\Http\Controllers\Account\Models\SubsidiaryLedger;
use App\Http\Controllers\Account\Models\SubsidiaryCalculation;
use App\Http\Controllers\Account\Models\AccountType;
use App\Http\Controllers\Account\Models\Group;
use App\Http\Controllers\Account\Models\SubsidiaryLedgerGroup;
use App\Http\Controllers\Account\Models\SubsidiaryLedgerCategory;
use App\Http\Controllers\Account\Models\PaymentVoucher;
use App\Http\Controllers\Account\AccountsHelper;
use Illuminate\Support\Facades\DB;

class PaymentVoucherController extends Controller
{
    public function index(Request $request)
    {
        // Debug: Check all transactions first
        $allTransactions = AccountTransaction::all();
        \Log::info('All transactions count: ' . $allTransactions->count());
        
        $query = AccountTransaction::with('accTransactionDetails')
            ->where('trans_type', 1) // Payment Voucher
            ->orderBy('created_at', 'desc');

        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('trans_date', [$request->date_from, $request->date_to]);
        }

        $paymentVouchers = $query->paginate(15);
        
        // Debug: Log the results
        \Log::info('Payment vouchers count: ' . $paymentVouchers->count());
        \Log::info('Payment vouchers: ', $paymentVouchers->toArray());

        return view('backend.accounts.payment-voucher.index', compact('paymentVouchers'));
    }

    /**
     * Create voucher form
     */
    public function create()
    {
        $groups = Group::with('subsidiaryLedgers')->where('account_type_id', 2)->where('status', 1)->get();
        $subsidiaryLedgers = SubsidiaryLedger::with('group')->where('status', 1)->get();

        return view('backend.accounts.payment-voucher.create', compact('groups', 'subsidiaryLedgers'));
    }

    /**
     * Store voucher
     */
    public function store(Request $request)
    {
        $request->validate([
            'trans_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'line_items' => 'required|array|min:1',
            'line_items.*.general_ledger_id' => 'required|integer',
            'line_items.*.payment_by_id' => 'required|integer',
            'line_items.*.amount' => 'required|numeric|min:0',
        ]);
    
        try {
            DB::beginTransaction();
    
            // 🔹 Generate Voucher Number
            $voucherCount = AccountTransaction::where('trans_type', 1)->count();
            $voucherNo = 'PV-' . date('Y') . '-' . str_pad($voucherCount + 1, 4, '0', STR_PAD_LEFT);
    
            // 🔹 Create Master Transaction
            $paymentVoucher = AccountTransaction::create([
                'voucher_no'     => $voucherNo,
                'voucher_int_no' => $voucherCount + 1,
                'auto_voucher'   => 0,
                'status'         => 1,
                'amount'         => $request->total_amount,
                'comments'       => $request->remarks ?? null,
                'trans_date'     => $request->trans_date,
                'trans_type'     => 1, // Payment Voucher
                'created_by'     => auth()->id(),
            ]);
           
            $transaction_id = $paymentVoucher->id;
            // dd($transaction_id);    
            // 🔹 Loop through line items
            foreach ($request->line_items as $item) {
    
                $creditLedger = SubsidiaryLedger::findOrFail($item['payment_by_id']);
                $debitLedger  = SubsidiaryLedger::findOrFail($item['general_ledger_id']);
    
                // 🔹 Create Transaction Detail (Child)
                $detail = AccountTransactionDetail::create([
                    'acc_transaction_id'  => $transaction_id,
                    'dr_adjust_trans_id'  => 0,
                    'dr_adjust_voucher_no'=> null,
                    'dr_adjust_voucher_date' => null,
                    'cr_adjust_trans_id'  => 0,
                    'cr_adjust_voucher_no'=> null,
                    'cr_adjust_voucher_date' => null,
                    'dr_gl_ledger'        => $debitLedger->group_id,
                    'dr_sub_ledger'       => $debitLedger->id,
                    'cr_gl_ledger'        => $creditLedger->group_id,
                    'cr_sub_ledger'       => $creditLedger->id,
                    'ref_sub_ledger'      => 0,
                    'amount'              => $item['amount'],
                    'created_by'          => auth()->id(),
                ]);
    
                $tran_details_id = $detail->id;
    
                // 🔹 Double Entry in SubsidiaryCalculation
                SubsidiaryCalculation::create([
                    'particular'              => $creditLedger->id,
                    'particular_control_group' => $creditLedger->group_id,
                    'trans_date'              => $request->trans_date,
                    'sub_ledger'              => $debitLedger->id,
                    'gl_ledger'               => $debitLedger->group_id,
                    'nature_id'               => $debitLedger->account_type ?? 2,
                    'debit_amount'            => $item['amount'],
                    'credit_amount'           => 0,
                    'transaction_type'        => 2, // Child transaction
                    'transaction_id'          => $transaction_id,
                    'tran_details_id'         => $tran_details_id,
                    'adjust_trans_id'         => null,
                    'adjust_voucher_date'     => null,
                    'created_by'              => auth()->id(),
                ]);
    
                SubsidiaryCalculation::create([
                    'particular'              => $debitLedger->id,
                    'particular_control_group' => $debitLedger->group_id,
                    'trans_date'              => $request->trans_date,
                    'sub_ledger'              => $creditLedger->id,
                    'gl_ledger'               => $creditLedger->group_id,
                    'nature_id'               => $creditLedger->account_type ?? 2,
                    'debit_amount'            => 0,
                    'credit_amount'           => $item['amount'],
                    'transaction_type'        => 2,
                    'transaction_id'          => $transaction_id,
                    'tran_details_id'         => $tran_details_id,
                    'adjust_trans_id'         => null,
                    'adjust_voucher_date'     => null,
                    'created_by'              => auth()->id(),
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('payment-voucher.index')
                ->with('success', "Payment voucher created successfully! Voucher No: {$voucherNo}");
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment Voucher Store Error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Error creating payment voucher: '.$e->getMessage());
        }
    }
    

    /**
     * Edit voucher form
     */
    public function edit($id)
    {
        $paymentVoucher = AccountTransaction::with('accTransactionDetails')->findOrFail($id);
        $groups = Group::with('subsidiaryLedgers')->where('status', 1)->get();
        $subsidiaryLedgers = SubsidiaryLedger::with('group')->where('status', 1)->get();

        return view('backend.accounts.payment-voucher.edit', compact('paymentVoucher', 'groups', 'subsidiaryLedgers'));
    }

    /**
     * Update voucher
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'trans_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'line_items' => 'required|array|min:1',
            'line_items.*.general_ledger_id' => 'required|integer',
            'line_items.*.payment_by_id' => 'required|integer',
            'line_items.*.amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $paymentVoucher = AccountTransaction::findOrFail($id);
            $paymentVoucher->update([
                'trans_date' => $request->trans_date,
                'amount' => $request->total_amount,
                'comments' => $request->remarks,
                'updated_by' => auth()->id(),
            ]);

            // Details Delete and New Details Add
            AccountTransactionDetail::where('acc_transaction_id', $id)->delete();
            SubsidiaryCalculation::where('transaction_id', $id)->delete();

            foreach ($request->line_items as $item) {
                $creditLedger = SubsidiaryLedger::findOrFail($item['payment_by_id']);
                $debitLedger = SubsidiaryLedger::findOrFail($item['general_ledger_id']);

                $detail = AccountTransactionDetail::create([
                    'acc_transaction_id' => $paymentVoucher->id,
                    'dr_adjust_trans_id' => 0,
                    'dr_adjust_voucher_no' => null,
                    'dr_adjust_voucher_date' => null,
                    'cr_adjust_trans_id' => 0,
                    'cr_adjust_voucher_no' => null,
                    'cr_adjust_voucher_date' => null,
                    'dr_gl_ledger' => $debitLedger->group_id,
                    'dr_sub_ledger' => $debitLedger->id,
                    'cr_gl_ledger' => $creditLedger->group_id,
                    'cr_sub_ledger' => $creditLedger->id,
                    'ref_sub_ledger' => 0,
                    'amount' => $item['amount'],
                    'created_by' => auth()->id(),
                ]);

                $tran_details_id = $detail->id;

                // Double Entry in SubsidiaryCalculation
                SubsidiaryCalculation::create([
                    'particular' => $creditLedger->id,
                    'particular_control_group' => $creditLedger->group_id,
                    'trans_date' => $request->trans_date,
                    'sub_ledger' => $debitLedger->id,
                    'gl_ledger' => $debitLedger->group_id,
                    'nature_id' => $debitLedger->account_type ?? 2,
                    'debit_amount' => $item['amount'],
                    'credit_amount' => 0,
                    'transaction_type' => 2,
                    'transaction_id' => $paymentVoucher->id,
                    'tran_details_id' => $tran_details_id,
                    'adjust_trans_id' => null,
                    'adjust_voucher_date' => null,
                    'created_by' => auth()->id(),
                ]);

                SubsidiaryCalculation::create([
                    'particular' => $debitLedger->id,
                    'particular_control_group' => $debitLedger->group_id,
                    'trans_date' => $request->trans_date,
                    'sub_ledger' => $creditLedger->id,
                    'gl_ledger' => $creditLedger->group_id,
                    'nature_id' => $creditLedger->account_type ?? 2,
                    'debit_amount' => 0,
                    'credit_amount' => $item['amount'],
                    'transaction_type' => 2,
                    'transaction_id' => $paymentVoucher->id,
                    'tran_details_id' => $tran_details_id,
                    'adjust_trans_id' => null,
                    'adjust_voucher_date' => null,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('payment-voucher.index')->with('success', 'Payment voucher updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete voucher
     */
    public function destroy($id)
    {
        $paymentVoucher = AccountTransaction::findOrFail($id);
        $paymentVoucher->delete();

        return redirect()->route('payment-voucher.index')->with('success', 'Payment Voucher deleted successfully');
    }

    /**
     * Show voucher details
     */
    public function show($id)
    {
        $paymentVoucher = AccountTransaction::with('accTransactionDetails')->findOrFail($id);
        
        // Separate debit and credit entries
        $debitEntries = [];
        $creditEntries = [];
        $totalDebit = 0;
        $totalCredit = 0;
        
        foreach ($paymentVoucher->accTransactionDetails as $detail) {
            // Get debit ledger details
            $debitLedger = \App\Http\Controllers\Account\Models\SubsidiaryLedger::find($detail->dr_sub_ledger);
            $creditLedger = \App\Http\Controllers\Account\Models\SubsidiaryLedger::find($detail->cr_sub_ledger);
            
            // Group debit entries
            $debitKey = $detail->dr_sub_ledger;
            if (!isset($debitEntries[$debitKey])) {
                $debitEntries[$debitKey] = [
                    'code' => $debitLedger->ledger_code ?? $detail->dr_sub_ledger,
                    'particulars' => $debitLedger->name ?? 'N/A',
                    'amount' => 0
                ];
            }
            $debitEntries[$debitKey]['amount'] += $detail->amount;
            $totalDebit += $detail->amount;
            
            // Group credit entries
            $creditKey = $detail->cr_sub_ledger;
            if (!isset($creditEntries[$creditKey])) {
                $creditEntries[$creditKey] = [
                    'code' => $creditLedger->ledger_code ?? $detail->cr_sub_ledger,
                    'particulars' => $creditLedger->name ?? 'N/A',
                    'amount' => 0
                ];
            }
            $creditEntries[$creditKey]['amount'] += $detail->amount;
            $totalCredit += $detail->amount;
        }
        
        $amountInWords = AccountsHelper::numberToWords($totalDebit) . ' Taka Only';
        
        return view('backend.accounts.payment-voucher.show', compact('paymentVoucher', 'debitEntries', 'creditEntries', 'totalDebit', 'totalCredit', 'amountInWords'));
    }

    /**
     * Print voucher
     */
    public function print($id)
    {
        $paymentVoucher = AccountTransaction::with('accTransactionDetails')->findOrFail($id);
        
        // Separate debit and credit entries
        $debitEntries = [];
        $creditEntries = [];
        $totalDebit = 0;
        $totalCredit = 0;
        
        foreach ($paymentVoucher->accTransactionDetails as $detail) {
            // Get debit ledger details
            $debitLedger = \App\Http\Controllers\Account\Models\SubsidiaryLedger::find($detail->dr_sub_ledger);
            $creditLedger = \App\Http\Controllers\Account\Models\SubsidiaryLedger::find($detail->cr_sub_ledger);
            
            // Group debit entries
            $debitKey = $detail->dr_sub_ledger;
            if (!isset($debitEntries[$debitKey])) {
                $debitEntries[$debitKey] = [
                    'code' => $debitLedger->ledger_code ?? $detail->dr_sub_ledger,
                    'particulars' => $debitLedger->name ?? 'N/A',
                    'amount' => 0
                ];
            }
            $debitEntries[$debitKey]['amount'] += $detail->amount;
            $totalDebit += $detail->amount;
            
            // Group credit entries
            $creditKey = $detail->cr_sub_ledger;
            if (!isset($creditEntries[$creditKey])) {
                $creditEntries[$creditKey] = [
                    'code' => $creditLedger->ledger_code ?? $detail->cr_sub_ledger,
                    'particulars' => $creditLedger->name ?? 'N/A',
                    'amount' => 0
                ];
            }
            $creditEntries[$creditKey]['amount'] += $detail->amount;
            $totalCredit += $detail->amount;
        }
        
        $amountInWords = AccountsHelper::numberToWords($totalDebit) . ' Taka Only';
        
        return view('backend.accounts.payment-voucher.print', compact('paymentVoucher', 'debitEntries', 'creditEntries', 'totalDebit', 'totalCredit', 'amountInWords'));
    }

    
}
