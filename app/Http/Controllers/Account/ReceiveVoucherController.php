<?php
//devmonir date 07-09-2025 16:00 pm 
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Account\Models\AccountTransaction;
use App\Http\Controllers\Account\Models\AccountTransactionDetail;
use App\Http\Controllers\Account\Models\SubsidiaryLedger;
use App\Http\Controllers\Account\Models\SubsidiaryCalculation;
use App\Http\Controllers\Account\Models\AccountType;
use App\Http\Controllers\Account\Models\Group;
use App\Http\Controllers\Account\Models\SubsidiaryLedgerGroup;
use App\Http\Controllers\Account\Models\SubsidiaryLedgerCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReceiveVoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountTransaction::where('trans_type', 2); // 2 = Receive Transaction
        
        // Search by voucher number
        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }
        
        // Search by date range
        if ($request->filled('date_from')) {
            $query->whereDate('trans_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('trans_date', '<=', $request->date_to);
        }
        
        $receiveVouchers = $query->with('accTransactionDetails')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('backend.accounts.receive-voucher.index', compact('receiveVouchers'));
    }
    
    public function create()
    {
        $groups = Group::with('subsidiaryLedgers')->where('status', 1)->get();
        $subsidiaryLedgers = SubsidiaryLedger::with('group')->where('status', 1)->get();

        return view('backend.accounts.receive-voucher.create', compact('groups', 'subsidiaryLedgers'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'trans_date' => 'required|date',
            'line_items' => 'required|array|min:1',
            'line_items.*.received_from_id' => 'required|exists:account_subsidiary_ledgers,id',
            'line_items.*.credit_to_id' => 'required|exists:account_subsidiary_ledgers,id',
            'line_items.*.amount' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::beginTransaction();

            // Generate voucher number
            $voucherNo = 'RV-' . str_pad(AccountTransaction::where('trans_type', 2)->count() + 1, 6, '0', STR_PAD_LEFT);

            // Calculate total amount
            $totalAmount = array_sum(array_column($request->line_items, 'amount'));

            // Create main transaction
            $transaction = AccountTransaction::create([
                'voucher_no' => $voucherNo,
                'voucher_int_no' => AccountTransaction::where('trans_type', 2)->count() + 1,
                'trans_type' => 2, // 2 = Receive Transaction
                'trans_date' => $request->trans_date,
                'amount' => $totalAmount,
                'comments' => $request->remarks,
                'status' => 1, // 1 = Active
                'auto_voucher' => 1,
                'created_by' => auth()->id(),
                'valid' => 1
            ]);

            // Create transaction details
            foreach ($request->line_items as $item) {
                $creditLedger = SubsidiaryLedger::findOrFail($item['credit_to_id']);
                $debitLedger = SubsidiaryLedger::findOrFail($item['received_from_id']);

                $detail = AccountTransactionDetail::create([
                    'acc_transaction_id' => $transaction->id,
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
                    'transaction_id' => $transaction->id,
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
                    'transaction_id' => $transaction->id,
                    'tran_details_id' => $tran_details_id,
                    'adjust_trans_id' => null,
                    'adjust_voucher_date' => null,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->route('voucher.receive')->with('success', 'Receive voucher created successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error creating receive voucher: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $receiveVoucher = AccountTransaction::with('accTransactionDetails')->findOrFail($id);
        
        $debitEntries = [];
        $creditEntries = [];
        $totalDebit = 0;
        $totalCredit = 0;
        
        foreach ($receiveVoucher->accTransactionDetails as $detail) {
            $debitLedger = SubsidiaryLedger::find($detail->dr_sub_ledger);
            $creditLedger = SubsidiaryLedger::find($detail->cr_sub_ledger);
            
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
        
        $amountInWords = $this->numberToWords($totalDebit) . ' Taka Only';
        
        return view('backend.accounts.receive-voucher.show', compact('receiveVoucher', 'debitEntries', 'creditEntries', 'totalDebit', 'totalCredit', 'amountInWords'));
    }
    
    public function print($id)
    {
        $receiveVoucher = AccountTransaction::with('accTransactionDetails')->findOrFail($id);
        
        $debitEntries = [];
        $creditEntries = [];
        $totalDebit = 0;
        $totalCredit = 0;
        
        foreach ($receiveVoucher->accTransactionDetails as $detail) {
            $debitLedger = SubsidiaryLedger::find($detail->dr_sub_ledger);
            $creditLedger = SubsidiaryLedger::find($detail->cr_sub_ledger);
            
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
        
        $amountInWords = $this->numberToWords($totalDebit) . ' Taka Only';
        
        return view('backend.accounts.receive-voucher.print', compact('receiveVoucher', 'debitEntries', 'creditEntries', 'totalDebit', 'totalCredit', 'amountInWords'));
    }
    
    public function edit($id)
    {
        $receiveVoucher = AccountTransaction::with('accTransactionDetails')->findOrFail($id);
        $groups = Group::with('subsidiaryLedgers')->where('status', 1)->get();
        $subsidiaryLedgers = SubsidiaryLedger::with('group')->where('status', 1)->get();

        return view('backend.accounts.receive-voucher.edit', compact('receiveVoucher', 'groups', 'subsidiaryLedgers'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'trans_date' => 'required|date',
            'line_items' => 'required|array|min:1',
            'line_items.*.received_from_id' => 'required|exists:account_subsidiary_ledgers,id',
            'line_items.*.credit_to_id' => 'required|exists:account_subsidiary_ledgers,id',
            'line_items.*.amount' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::beginTransaction();

            $receiveVoucher = AccountTransaction::findOrFail($id);
            
            // Calculate total amount
            $totalAmount = array_sum(array_column($request->line_items, 'amount'));

            // Update main transaction
            $receiveVoucher->update([
                'trans_date' => $request->trans_date,
                'amount' => $totalAmount,
                'comments' => $request->remarks,
                'updated_by' => auth()->id(),
            ]);

            // Delete existing transaction details and subsidiary calculations
            AccountTransactionDetail::where('acc_transaction_id', $id)->delete();
            SubsidiaryCalculation::where('transaction_id', $id)->delete();

            // Create new transaction details
            foreach ($request->line_items as $item) {
                $creditLedger = SubsidiaryLedger::findOrFail($item['credit_to_id']);
                $debitLedger = SubsidiaryLedger::findOrFail($item['received_from_id']);

                $detail = AccountTransactionDetail::create([
                    'acc_transaction_id' => $receiveVoucher->id,
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
                    'transaction_id' => $receiveVoucher->id,
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
                    'transaction_id' => $receiveVoucher->id,
                    'tran_details_id' => $tran_details_id,
                    'adjust_trans_id' => null,
                    'adjust_voucher_date' => null,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->route('voucher.receive')->with('success', 'Receive voucher updated successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error updating receive voucher: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $transaction = AccountTransaction::findOrFail($id);
            $transaction->accTransactionDetails()->delete();
            $transaction->delete();
            
            DB::commit();
            return redirect()->route('voucher.receive')->with('success', 'Receive voucher deleted successfully');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error deleting receive voucher: ' . $e->getMessage());
        }
    }
    
    private function numberToWords($number)
    {
        $ones = array(
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
        );
        
        $tens = array(
            2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
            6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
        );
        
        $number = (int)$number;
        
        if ($number == 0) return 'Zero';
        
        $result = '';
        
        // Crores
        if ($number >= 10000000) {
            $crores = intval($number / 10000000);
            $result .= $this->convertHundreds($crores, $ones, $tens) . ' Crore ';
            $number %= 10000000;
        }
        
        // Lakhs
        if ($number >= 100000) {
            $lakhs = intval($number / 100000);
            $result .= $this->convertHundreds($lakhs, $ones, $tens) . ' Lakh ';
            $number %= 100000;
        }
        
        // Thousands
        if ($number >= 1000) {
            $thousands = intval($number / 1000);
            $result .= $this->convertHundreds($thousands, $ones, $tens) . ' Thousand ';
            $number %= 1000;
        }
        
        // Hundreds
        if ($number >= 100) {
            $hundreds = intval($number / 100);
            $result .= $ones[$hundreds] . ' Hundred ';
            $number %= 100;
        }
        
        // Tens and Ones
        if ($number > 0) {
            if ($number < 20) {
                $result .= $ones[$number];
            } else {
                $tensDigit = intval($number / 10);
                $onesDigit = $number % 10;
                $result .= $tens[$tensDigit];
                if ($onesDigit > 0) {
                    $result .= ' ' . $ones[$onesDigit];
                }
            }
        }
        
        return trim($result);
    }
    
    private function convertHundreds($number, $ones, $tens)
    {
        $result = '';
        
        if ($number >= 100) {
            $hundreds = intval($number / 100);
            $result .= $ones[$hundreds] . ' Hundred ';
            $number %= 100;
        }
        
        if ($number > 0) {
            if ($number < 20) {
                $result .= $ones[$number];
            } else {
                $tensDigit = intval($number / 10);
                $onesDigit = $number % 10;
                $result .= $tens[$tensDigit];
                if ($onesDigit > 0) {
                    $result .= ' ' . $ones[$onesDigit];
                }
            }
        }
        
        return trim($result);
    }
}
