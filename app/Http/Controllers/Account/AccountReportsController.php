<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Account\Models\AccountTransaction;
use App\Http\Controllers\Account\Models\AccountTransactionDetail;
use App\Http\Controllers\Account\Models\SubsidiaryLedger;
use App\Http\Controllers\Account\Models\Group;
use Illuminate\Support\Facades\DB;

class AccountReportsController extends Controller
{
    public function journalReport(Request $request)
    {
        // Get all ledgers for filter dropdown
        $ledgers = SubsidiaryLedger::with('group')->where('status', 1)->orderBy('name')->get();
        
        // Load initial data for display using AccountTransactionDetail
        $query = AccountTransactionDetail::with(['accountTransaction', 'drSubLedger', 'crSubLedger'])
        ->whereHas('accountTransaction', function ($q) use ($request) {
            // শুধু Journal transaction
            $q->where('trans_type', 3);

            // Date range filter
            if ($request->filled('from_date')) {
                $q->where('trans_date', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $q->where('trans_date', '<=', $request->to_date);
            }

            // Voucher number filter
            if ($request->filled('voucher_no')) {
                $q->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
            }
        });

        // Ledger filter (Detail side)
        if ($request->filled('ledger_id')) {
            $query->where(function($q) use ($request) {
                $q->where('dr_sub_ledger', $request->ledger_id)
                  ->orWhere('cr_sub_ledger', $request->ledger_id);
            });
        }

        $transactions = $query->orderByDesc(
            AccountTransaction::select('trans_date')
                ->whereColumn('account_transactions.id', 'account_transaction_details.acc_transaction_id')
                ->limit(1)
        )->get();

        $filteredTransactions = collect();
        $totalDebit = 0;
        $totalCredit = 0;
        $transactionCount = 0;

        foreach ($transactions as $detail) {
            $transaction = $detail->accountTransaction;

            if (!$transaction) {
                continue;
            }

            if ($request->filled('ledger_id')) {
                if ($detail->dr_sub_ledger == $request->ledger_id) {
                    $totalDebit += $detail->amount;
                } elseif ($detail->cr_sub_ledger == $request->ledger_id) {
                    $totalCredit += $detail->amount;
                }
            } else {
                // Always add to both debit and credit for journal entries
                $totalDebit += $detail->amount;
                $totalCredit += $detail->amount;
            }

            $filteredTransactions->push($detail);
            $transactionCount++;
        }

        $transactions = $filteredTransactions;
        
        \Log::info('Journal Report Summary:', [
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'transactionCount' => $transactionCount
        ]);
        
        return view('backend.accounts.reports.journal-report', compact('ledgers', 'transactions', 'totalDebit', 'totalCredit', 'transactionCount'));
    }

    public function journalReportGetData(Request $request)
    {
        try {
            // \Log::info('Journal Report Data Request:', ['request' => $request->all()]);

            $query = AccountTransactionDetail::with(['accountTransaction', 'drSubLedger', 'crSubLedger'])
            ->whereHas('accountTransaction', function ($q) use ($request) {
                // শুধু Journal transaction
                $q->where('trans_type', 3);

                // Date range filter
                if ($request->filled('from_date')) {
                    $q->where('trans_date', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $q->where('trans_date', '<=', $request->to_date);
                }

                // Voucher number filter
                if ($request->filled('voucher_no')) {
                    $q->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
                }
            });

            // Ledger filter (Detail side)
            if ($request->filled('ledger_id')) {
                $query->where(function($q) use ($request) {
                    $q->where('dr_sub_ledger', $request->ledger_id)
                    ->orWhere('cr_sub_ledger', $request->ledger_id);
                });
            }

            $transactions = $query->orderByDesc(
                AccountTransaction::select('trans_date')
                    ->whereColumn('account_transactions.id', 'account_transaction_details.acc_transaction_id')
                    ->limit(1)
            )->get();

            $filteredTransactions = collect();
            $totalDebit = 0;
            $totalCredit = 0;
            $transactionCount = 0;

            foreach ($transactions as $detail) {
                $transaction = $detail->accountTransaction;

                if (!$transaction) {
                    continue;
                }

                if ($request->filled('ledger_id')) {
                    if ($detail->dr_sub_ledger == $request->ledger_id) {
                        $totalDebit += $detail->amount;
                    } elseif ($detail->cr_sub_ledger == $request->ledger_id) {
                        $totalCredit += $detail->amount;
                    }
                } else {
                    // Always add to both debit and credit for journal entries
                    $totalDebit += $detail->amount;
                    $totalCredit += $detail->amount;
                }

                $filteredTransactions->push($detail);
                $transactionCount++;
            }

            \Log::info('Final Summary:', [
                'totalDebit' => $totalDebit,
                'totalCredit' => $totalCredit,
                'transactionCount' => $transactionCount
            ]);

            return response()->json([
                'success' => true,
                'data' => $filteredTransactions,
                'summary' => [
                    'totalDebit' => $totalDebit,
                    'totalCredit' => $totalCredit,
                    'transactionCount' => $transactionCount
                ]
            ]);
        } catch (\Exception $e) {
            // \Log::error('Journal Report Error:', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading data: ' . $e->getMessage()
            ]);
        }
    }



    
    // lagerReport
    public function lagerReport(Request $request)
    {
        // Get all ledgers for filter dropdown
        $ledgers = SubsidiaryLedger::with('group')->where('status', 1)->orderBy('name')->get();
        
        // Load initial data for display
        $query = AccountTransaction::with(['accTransactionDetails' => function($q) {
            $q->with(['drSubLedger', 'crSubLedger']);
        }])->where('trans_type', 3); // Using journal transactions for testing

        // Date range filter
        if ($request->filled('from_date')) {
            $query->where('trans_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('trans_date', '<=', $request->to_date);
        }

        // Voucher number filter
        if ($request->filled('voucher_no')) {
            $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
        }

        $transactions = $query->orderBy('trans_date', 'asc')->get();

        // Process transactions for ledger format
        $ledgerData = collect();
        $totalDebit = 0;
        $totalCredit = 0;
        $transactionCount = 0;

        foreach ($transactions as $transaction) {
            foreach ($transaction->accTransactionDetails as $detail) {
                // Apply ledger filter if specified
                if ($request->filled('ledger_id')) {
                    if ($detail->dr_sub_ledger != $request->ledger_id && $detail->cr_sub_ledger != $request->ledger_id) {
                        continue;
                    }
                }

                $ledgerData->push([
                    'account_transaction' => $transaction,
                    'dr_sub_ledger' => $detail->drSubLedger,
                    'cr_sub_ledger' => $detail->crSubLedger,
                    'amount' => $detail->amount,
                    'acc_transaction_id' => $detail->acc_transaction_id
                ]);

                $totalDebit += $detail->amount;
                $totalCredit += $detail->amount;
                $transactionCount++;
            }
        }
        
        \Log::info('Lager Report Summary:', [
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'transactionCount' => $transactionCount
        ]);
        
        return view('backend.accounts.reports.lager-report', compact('ledgers', 'totalDebit', 'totalCredit', 'transactionCount'));
    }

    public function lagerReportGetData(Request $request)
    {
        try {
            // Get all journal transactions (using trans_type = 3 for testing)
            $query = AccountTransaction::with(['accTransactionDetails' => function($q) {
                $q->with(['drSubLedger', 'crSubLedger']);
            }])->where('trans_type', 3);

            // Date range filter
            if ($request->filled('from_date')) {
                $query->where('trans_date', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->where('trans_date', '<=', $request->to_date);
            }

            // Voucher number filter
            if ($request->filled('voucher_no')) {
                $query->where('voucher_no', 'like', '%' . $request->voucher_no . '%');
            }

            $transactions = $query->orderBy('trans_date', 'asc')->get();

            \Log::info('Lager Report Query Result:', [
                'total_transactions' => $transactions->count(),
                'first_few' => $transactions->take(3)->toArray()
            ]);

            // Process transactions for ledger format
            $ledgerData = collect();
            $totalDebit = 0;
            $totalCredit = 0;
            $transactionCount = 0;

            foreach ($transactions as $transaction) {
                foreach ($transaction->accTransactionDetails as $detail) {
                    // Apply ledger filter if specified
                    if ($request->filled('ledger_id')) {
                        if ($detail->dr_sub_ledger != $request->ledger_id && $detail->cr_sub_ledger != $request->ledger_id) {
                            continue;
                        }
                    }

                    $ledgerData->push([
                        'account_transaction' => $transaction,
                        'dr_sub_ledger' => $detail->drSubLedger,
                        'cr_sub_ledger' => $detail->crSubLedger,
                        'amount' => $detail->amount,
                        'acc_transaction_id' => $detail->acc_transaction_id
                    ]);

                    $totalDebit += $detail->amount;
                    $totalCredit += $detail->amount;
                    $transactionCount++;
                }
            }

            \Log::info('Final Lager Summary:', [
                'totalDebit' => $totalDebit,
                'totalCredit' => $totalCredit,
                'transactionCount' => $transactionCount
            ]);

            return response()->json([
                'success' => true,
                'data' => $ledgerData,
                'summary' => [
                    'totalDebit' => $totalDebit,
                    'totalCredit' => $totalCredit,
                    'transactionCount' => $transactionCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading data: ' . $e->getMessage()
            ]);
        }
    }

   
    // balanceSheetReport
    public function balanceSheetReport(Request $request)
    {
        // Get all ledgers for filter dropdown
        $ledgers = SubsidiaryLedger::with('group')->where('status', 1)->orderBy('name')->get();
        
        // Get balance sheet data from database
        $balanceSheetData = $this->getBalanceSheetData();

        return view('backend.accounts.reports.balance-sheet-report', compact('balanceSheetData', 'ledgers'));
    }
    
    public function balanceSheetReportGetData(Request $request)
    {
        try {
            // Get balance sheet data from database
            $balanceSheetData = $this->getBalanceSheetData();

            return response()->json([
                'success' => true,
                'data' => $balanceSheetData,
                'message' => 'Balance sheet data loaded successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading balance sheet data: ' . $e->getMessage()
            ]);
        }
    }

    private function getBalanceSheetData()
    {
        try {
            // Get all transactions with their details
            $transactions = AccountTransaction::with(['accTransactionDetails' => function($q) {
                $q->with(['drSubLedger', 'crSubLedger']);
            }])->get();

            // Initialize balance sheet structure
            $balanceSheetData = [
                'assets' => [
                    'current_assets' => [],
                    'fixed_assets' => [],
                    'total_assets' => 0
                ],
                'liabilities' => [
                    'current_liabilities' => [],
                    'long_term_liabilities' => [],
                    'total_liabilities' => 0
                ],
                'equity' => [
                    'owner_equity' => [],
                    'total_equity' => 0
                ]
            ];

            // Process transactions to calculate balances
            $ledgerBalances = [];
            
            foreach ($transactions as $transaction) {
                foreach ($transaction->accTransactionDetails as $detail) {
                    $drLedgerId = $detail->dr_sub_ledger_id;
                    $crLedgerId = $detail->cr_sub_ledger_id;
                    $amount = $detail->amount;

                    // Debit side
                    if ($drLedgerId) {
                        if (!isset($ledgerBalances[$drLedgerId])) {
                            $ledgerBalances[$drLedgerId] = [
                                'name' => $detail->drSubLedger->name ?? 'Unknown',
                                'code' => $detail->drSubLedger->code ?? '',
                                'debit' => 0,
                                'credit' => 0,
                                'balance' => 0
                            ];
                        }
                        $ledgerBalances[$drLedgerId]['debit'] += $amount;
                        $ledgerBalances[$drLedgerId]['balance'] += $amount;
                    }

                    // Credit side
                    if ($crLedgerId) {
                        if (!isset($ledgerBalances[$crLedgerId])) {
                            $ledgerBalances[$crLedgerId] = [
                                'name' => $detail->crSubLedger->name ?? 'Unknown',
                                'code' => $detail->crSubLedger->code ?? '',
                                'debit' => 0,
                                'credit' => 0,
                                'balance' => 0
                            ];
                        }
                        $ledgerBalances[$crLedgerId]['credit'] += $amount;
                        $ledgerBalances[$crLedgerId]['balance'] -= $amount;
                    }
                }
            }

            // Categorize ledgers based on their groups
            foreach ($ledgerBalances as $ledgerId => $ledger) {
                $ledgerInfo = SubsidiaryLedger::with('group')->find($ledgerId);
                
                if ($ledgerInfo && $ledgerInfo->group) {
                    $groupName = strtolower($ledgerInfo->group->name);
                    
                    // Categorize based on group
                    if (strpos($groupName, 'asset') !== false) {
                        if (strpos($groupName, 'current') !== false || strpos($groupName, 'bank') !== false || strpos($groupName, 'cash') !== false) {
                            $balanceSheetData['assets']['current_assets'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        } else {
                            $balanceSheetData['assets']['fixed_assets'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        }
                    } elseif (strpos($groupName, 'liability') !== false) {
                        if (strpos($groupName, 'current') !== false) {
                            $balanceSheetData['liabilities']['current_liabilities'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        } else {
                            $balanceSheetData['liabilities']['long_term_liabilities'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        }
                    } elseif (strpos($groupName, 'equity') !== false || strpos($groupName, 'capital') !== false) {
                        $balanceSheetData['equity']['owner_equity'][] = [
                            'name' => $ledger['name'],
                            'code' => $ledger['code'],
                            'balance' => abs($ledger['balance'])
                        ];
                    }
                }
            }

            // Calculate totals
            $balanceSheetData['assets']['total_assets'] = 
                array_sum(array_column($balanceSheetData['assets']['current_assets'], 'balance')) +
                array_sum(array_column($balanceSheetData['assets']['fixed_assets'], 'balance'));

            $balanceSheetData['liabilities']['total_liabilities'] = 
                array_sum(array_column($balanceSheetData['liabilities']['current_liabilities'], 'balance')) +
                array_sum(array_column($balanceSheetData['liabilities']['long_term_liabilities'], 'balance'));

            $balanceSheetData['equity']['total_equity'] = 
                array_sum(array_column($balanceSheetData['equity']['owner_equity'], 'balance'));

            return $balanceSheetData;

        } catch (\Exception $e) {
            \Log::error('Error getting balance sheet data: ' . $e->getMessage());
            return [
                'assets' => ['current_assets' => [], 'fixed_assets' => [], 'total_assets' => 0],
                'liabilities' => ['current_liabilities' => [], 'long_term_liabilities' => [], 'total_liabilities' => 0],
                'equity' => ['owner_equity' => [], 'total_equity' => 0]
            ];
        }
    }

    // incomeStatementReport
    public function incomeStatementReport()
    {
        $ledgers = SubsidiaryLedger::with('group')->where('status', 1)->orderBy('name')->get();
        
        // Get income statement data from database
        $incomeStatementData = $this->getIncomeStatementData();

        return view('backend.accounts.reports.income-statement-report', compact('incomeStatementData', 'ledgers'));
    }
    
    public function incomeStatementReportGetData(Request $request)
    {
        try {
            // Get income statement data from database
            $incomeStatementData = $this->getIncomeStatementData();

            return response()->json([
                'success' => true,
                'data' => $incomeStatementData,
                'message' => 'Income statement data loaded successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading income statement data: ' . $e->getMessage()
            ]);
        }
    }

    private function getIncomeStatementData()
    {
        try {
            // Get all transactions with their details
            $transactions = AccountTransaction::with(['accTransactionDetails' => function($q) {
                $q->with(['drSubLedger', 'crSubLedger']);
            }])->get();

            // Initialize income statement structure
            $incomeStatementData = [
                'revenue' => [
                    'operating_revenue' => [],
                    'other_revenue' => [],
                    'total_revenue' => 0
                ],
                'expenses' => [
                    'operating_expenses' => [],
                    'administrative_expenses' => [],
                    'other_expenses' => [],
                    'total_expenses' => 0
                ],
                'net_income' => 0
            ];

            // Process transactions to calculate balances
            $ledgerBalances = [];
            
            foreach ($transactions as $transaction) {
                foreach ($transaction->accTransactionDetails as $detail) {
                    $drLedgerId = $detail->dr_sub_ledger_id;
                    $crLedgerId = $detail->cr_sub_ledger_id;
                    $amount = $detail->amount;

                    // Debit side
                    if ($drLedgerId) {
                        if (!isset($ledgerBalances[$drLedgerId])) {
                            $ledgerBalances[$drLedgerId] = [
                                'name' => $detail->drSubLedger->name ?? 'Unknown',
                                'code' => $detail->drSubLedger->code ?? '',
                                'debit' => 0,
                                'credit' => 0,
                                'balance' => 0
                            ];
                        }
                        $ledgerBalances[$drLedgerId]['debit'] += $amount;
                        $ledgerBalances[$drLedgerId]['balance'] += $amount;
                    }

                    // Credit side
                    if ($crLedgerId) {
                        if (!isset($ledgerBalances[$crLedgerId])) {
                            $ledgerBalances[$crLedgerId] = [
                                'name' => $detail->crSubLedger->name ?? 'Unknown',
                                'code' => $detail->crSubLedger->code ?? '',
                                'debit' => 0,
                                'credit' => 0,
                                'balance' => 0
                            ];
                        }
                        $ledgerBalances[$crLedgerId]['credit'] += $amount;
                        $ledgerBalances[$crLedgerId]['balance'] -= $amount;
                    }
                }
            }

            // Categorize ledgers based on their groups
            foreach ($ledgerBalances as $ledgerId => $ledger) {
                $ledgerInfo = SubsidiaryLedger::with('group')->find($ledgerId);
                
                if ($ledgerInfo && $ledgerInfo->group) {
                    $groupName = strtolower($ledgerInfo->group->name);
                    
                    // Categorize based on group
                    if (strpos($groupName, 'revenue') !== false || strpos($groupName, 'income') !== false || strpos($groupName, 'sales') !== false) {
                        if (strpos($groupName, 'operating') !== false || strpos($groupName, 'main') !== false) {
                            $incomeStatementData['revenue']['operating_revenue'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        } else {
                            $incomeStatementData['revenue']['other_revenue'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        }
                    } elseif (strpos($groupName, 'expense') !== false || strpos($groupName, 'cost') !== false) {
                        if (strpos($groupName, 'operating') !== false || strpos($groupName, 'main') !== false) {
                            $incomeStatementData['expenses']['operating_expenses'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        } elseif (strpos($groupName, 'administrative') !== false || strpos($groupName, 'admin') !== false) {
                            $incomeStatementData['expenses']['administrative_expenses'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        } else {
                            $incomeStatementData['expenses']['other_expenses'][] = [
                                'name' => $ledger['name'],
                                'code' => $ledger['code'],
                                'balance' => abs($ledger['balance'])
                            ];
                        }
                    }
                }
            }

            // Calculate totals
            $incomeStatementData['revenue']['total_revenue'] = 
                array_sum(array_column($incomeStatementData['revenue']['operating_revenue'], 'balance')) +
                array_sum(array_column($incomeStatementData['revenue']['other_revenue'], 'balance'));

            $incomeStatementData['expenses']['total_expenses'] = 
                array_sum(array_column($incomeStatementData['expenses']['operating_expenses'], 'balance')) +
                array_sum(array_column($incomeStatementData['expenses']['administrative_expenses'], 'balance')) +
                array_sum(array_column($incomeStatementData['expenses']['other_expenses'], 'balance'));

            $incomeStatementData['net_income'] = 
                $incomeStatementData['revenue']['total_revenue'] - $incomeStatementData['expenses']['total_expenses'];

            return $incomeStatementData;

        } catch (\Exception $e) {
            \Log::error('Error getting income statement data: ' . $e->getMessage());
            return [
                'revenue' => ['operating_revenue' => [], 'other_revenue' => [], 'total_revenue' => 0],
                'expenses' => ['operating_expenses' => [], 'administrative_expenses' => [], 'other_expenses' => [], 'total_expenses' => 0],
                'net_income' => 0
            ];
        }
    }
}
