<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\LedgerController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\ExpenseController;
use App\Http\Controllers\Account\PaymenttypeController;
use App\Http\Controllers\Account\TransactionController;
use App\Http\Controllers\Account\ExpenseCategoryController;
use App\Http\Controllers\Account\AccountTypeController;
use App\Http\Controllers\Account\GroupController;
use App\Http\Controllers\Account\SubsidiaryLedgerController;
use App\Http\Controllers\Account\ChartOfAccountsController;
use App\Http\Controllers\Account\PaymentVoucherController;
use App\Http\Controllers\Account\ReceiveVoucherController;
use App\Http\Controllers\Account\JournalVoucherController;
use App\Http\Controllers\Account\ContraVoucherController;
use App\Http\Controllers\Account\AccountReportsController;
use App\Http\Controllers\Account\AccountsConfigurationController;



Route::group(['prefix' => 'account', 'middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {
    // Payment Type
    Route::get('/add/new/payment-type', [PaymenttypeController::class, 'addNewPaymentType'])->name('AddNewPaymentType');
    Route::post('/save/new/payment-type', [PaymenttypeController::class, 'saveNewPaymentType'])->name('SaveNewPaymentType');
    Route::get('/view/all/payment-type', [PaymenttypeController::class, 'viewAllPaymentType'])->name('ViewAllPaymentType');
    Route::get('/delete/payment-type/{slug}', [PaymenttypeController::class, 'deletePaymentType'])->name('DeletePaymentType');
    Route::get('/edit/payment-type/{slug}', [PaymenttypeController::class, 'editPaymentType'])->name('EditPaymentType');
    Route::post('/update/payment-type', [PaymenttypeController::class, 'updatePaymentType'])->name('UpdatePaymentType');


    // Expense Category
    Route::get('/add/new/expense-category', [ExpenseCategoryController::class, 'addNewExpenseCategory'])->name('AddNewExpenseCategory');
    Route::post('/save/new/expense-category', [ExpenseCategoryController::class, 'saveNewExpenseCategory'])->name('SaveNewExpenseCategory');
    Route::get('/view/all/expense-category', [ExpenseCategoryController::class, 'viewAllExpenseCategory'])->name('ViewAllExpenseCategory');
    Route::get('/delete/expense-category/{slug}', [ExpenseCategoryController::class, 'deleteExpenseCategory'])->name('DeleteExpenseCategory');
    Route::get('/edit/expense-category/{slug}', [ExpenseCategoryController::class, 'editExpenseCategory'])->name('EditExpenseCategory');
    Route::post('/update/expense-category', [ExpenseCategoryController::class, 'updateExpenseCategory'])->name('UpdateExpenseCategory');

    // Account
    Route::get('/add/new/ac-account', [AccountController::class, 'addNewAcAccount'])->name('AddNewAcAccount');
    Route::post('/save/new/ac-account', [AccountController::class, 'saveNewAcAccount'])->name('SaveNewAcAccount');
    Route::get('/view/all/ac-account', [AccountController::class, 'viewAllAcAccount'])->name('ViewAllAcAccount');
    Route::get('/delete/ac-account/{slug}', [AccountController::class, 'deleteAcAccount'])->name('DeleteAcAccount');
    Route::get('/edit/ac-account/{slug}', [AccountController::class, 'editAcAccount'])->name('EditAcAccount');
    Route::post('/update/ac-account', [AccountController::class, 'updateAcAccount'])->name('UpdateAcAccount');
    Route::get('/get/ac-account/json', [AccountController::class, 'getJsonAcAccount'])->name('GetJsonAcAccount');
    Route::get('/get/ac-account-espense/json', [AccountController::class, 'getJsonAcAccountExpense'])->name('GetJsonAcAccountExpense');


    // Expense 
    Route::get('/add/new/expense', [ExpenseController::class, 'addNewExpense'])->name('AddNewExpense');
    Route::post('/save/new/expense', [ExpenseController::class, 'saveNewExpense'])->name('SaveNewExpense');
    Route::get('/view/all/expense', [ExpenseController::class, 'viewAllExpense'])->name('ViewAllExpense');
    Route::get('/delete/expense/{slug}', [ExpenseController::class, 'deleteExpense'])->name('DeleteExpense');
    Route::get('/edit/expense/{slug}', [ExpenseController::class, 'editExpense'])->name('EditExpense');
    Route::post('/update/expense', [ExpenseController::class, 'updateExpense'])->name('UpdateExpense');


    // Deposit 
    Route::get('/add/new/deposit', [TransactionController::class, 'addNewDeposit'])->name('AddNewDeposit');
    Route::post('/save/new/deposit', [TransactionController::class, 'saveNewDeposit'])->name('SaveNewDeposit');
    Route::get('/view/all/deposit', [TransactionController::class, 'viewAllDeposit'])->name('ViewAllDeposit');
    Route::get('/delete/deposit/{slug}', [TransactionController::class, 'deleteDeposit'])->name('DeleteDeposit');
    Route::get('/edit/deposit/{slug}', [TransactionController::class, 'editDeposit'])->name('EditDeposit');
    Route::post('/update/deposit', [TransactionController::class, 'updateDeposit'])->name('UpdateDeposit');


    // Ledger 
    Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index');
    Route::get('/ledger/journal', [LedgerController::class, 'journal'])->name('journal.index');
    Route::get('/ledger/balance-sheet', [LedgerController::class, 'balanceSheet'])->name('ledger.balance_sheet');
    Route::get('/ledger/income-statement', [LedgerController::class, 'incomeStatement'])->name('ledger.income_statement');


    // Chart of Accounts
    Route::prefix('accounts')->group(function () {
        Route::get('/account-types', [AccountTypeController::class, 'index'])->name('account-types.index');
        Route::get('/account-types/create', [AccountTypeController::class, 'create'])->name('account-types.create');
        Route::post('/account-types/store', [AccountTypeController::class, 'store'])->name('account-types.store');
        Route::get('/account-types/edit/{id}', [AccountTypeController::class, 'edit'])->name('account-types.edit');
        Route::put('/account-types/update/{id}', [AccountTypeController::class, 'update'])->name('account-types.update');
        Route::delete('/account-types/delete/{id}', [AccountTypeController::class, 'destroy'])->name('account-types.delete');
        Route::get('/account-types/toggle-status/{id}', [AccountTypeController::class, 'toggleStatus'])->name('account-types.toggle-status');
        
        Route::get('/groups', [GroupController::class, 'index'])->name('group.index');
        Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
        Route::post('/groups/store', [GroupController::class, 'store'])->name('groups.store');
        Route::get('/groups/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit');
        Route::put('/groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
        Route::delete('/groups/delete/{id}', [GroupController::class, 'destroy'])->name('groups.delete');
        Route::get('/groups/toggle-status/{id}', [GroupController::class, 'toggleStatus'])->name('groups.toggle-status');
        
        Route::get('/subsidiary-ledger', [SubsidiaryLedgerController::class, 'index'])->name('subsidiary-ledger.index');
        Route::get('/subsidiary-ledger/create', [SubsidiaryLedgerController::class, 'create'])->name('subsidiary-ledger.create');
        Route::post('/subsidiary-ledger/store', [SubsidiaryLedgerController::class, 'store'])->name('subsidiary-ledger.store');
        Route::get('/subsidiary-ledger/edit/{id}', [SubsidiaryLedgerController::class, 'edit'])->name('subsidiary-ledger.edit');
        Route::put('/subsidiary-ledger/update/{id}', [SubsidiaryLedgerController::class, 'update'])->name('subsidiary-ledger.update');
        Route::delete('/subsidiary-ledger/delete/{id}', [SubsidiaryLedgerController::class, 'destroy'])->name('subsidiary-ledger.delete');
        Route::get('/subsidiary-ledger/toggle-status/{id}', [SubsidiaryLedgerController::class, 'toggleStatus'])->name('subsidiary-ledger.toggle-status');
        
        Route::get('/chart-of-accounts', [ChartOfAccountsController::class, 'index'])->name('chart-of-accounts.index');
        
        // Accounts Configuration
        Route::get('/configuration', [AccountsConfigurationController::class, 'index'])->name('accounts-configuration.index');
        Route::get('/configuration/create', [AccountsConfigurationController::class, 'create'])->name('accounts-configuration.create');
        Route::post('/configuration/store', [AccountsConfigurationController::class, 'store'])->name('accounts-configuration.store');
        Route::get('/configuration/show/{accountsConfiguration}', [AccountsConfigurationController::class, 'show'])->name('accounts-configuration.show');
        Route::get('/configuration/edit/{accountsConfiguration}', [AccountsConfigurationController::class, 'edit'])->name('accounts-configuration.edit');
        Route::put('/configuration/update/{accountsConfiguration}', [AccountsConfigurationController::class, 'update'])->name('accounts-configuration.update');
        Route::delete('/configuration/destroy/{accountsConfiguration}', [AccountsConfigurationController::class, 'destroy'])->name('accounts-configuration.destroy');
        Route::post('/configuration/bulk-update', [AccountsConfigurationController::class, 'bulkUpdate'])->name('accounts-configuration.bulk-update');
        Route::post('/configuration/reset', [AccountsConfigurationController::class, 'resetToDefault'])->name('accounts-configuration.reset');
    });



    // Voucher Entry (Legacy)
    Route::prefix('voucher')->group(function () {
        Route::get('/payment', [PaymentVoucherController::class, 'index'])->name('voucher.payment');
        Route::post('/payment/store', [PaymentVoucherController::class, 'store'])->name('voucher.payment.store');
        Route::get('/payment/edit/{id}', [PaymentVoucherController::class, 'edit'])->name('voucher.payment.edit');
        Route::put('/payment/update/{id}', [PaymentVoucherController::class, 'update'])->name('voucher.payment.update');
        Route::delete('/payment/delete/{id}', [PaymentVoucherController::class, 'destroy'])->name('voucher.payment.delete');
        Route::get('/payment/toggle-status/{id}', [PaymentVoucherController::class, 'toggleStatus'])->name('voucher.payment.toggle-status');
    
        Route::get('/receive', [ReceiveVoucherController::class, 'index'])->name('voucher.receive');
        Route::get('/receive/create', [ReceiveVoucherController::class, 'create'])->name('voucher.receive.create');
        Route::post('/receive/store', [ReceiveVoucherController::class, 'store'])->name('voucher.receive.store');
        Route::get('/receive/show/{id}', [ReceiveVoucherController::class, 'show'])->name('voucher.receive.show');
        Route::get('/receive/print/{id}', [ReceiveVoucherController::class, 'print'])->name('voucher.receive.print');
        Route::get('/receive/edit/{id}', [ReceiveVoucherController::class, 'edit'])->name('voucher.receive.edit');
        Route::put('/receive/update/{id}', [ReceiveVoucherController::class, 'update'])->name('voucher.receive.update');
        Route::delete('/receive/delete/{id}', [ReceiveVoucherController::class, 'destroy'])->name('voucher.receive.delete');
    
        Route::get('/journal', [JournalVoucherController::class, 'index'])->name('voucher.journal');
        Route::post('/journal/store', [JournalVoucherController::class, 'store'])->name('voucher.journal.store');
        Route::get('/journal/edit/{id}', [JournalVoucherController::class, 'edit'])->name('voucher.journal.edit');
        Route::put('/journal/update/{id}', [JournalVoucherController::class, 'update'])->name('voucher.journal.update');
        Route::delete('/journal/delete/{id}', [JournalVoucherController::class, 'destroy'])->name('voucher.journal.delete');
        Route::get('/journal/toggle-status/{id}', [JournalVoucherController::class, 'toggleStatus'])->name('voucher.journal.toggle-status');
    
        Route::get('/contra', [ContraVoucherController::class, 'index'])->name('voucher.contra');
        Route::post('/contra/store', [ContraVoucherController::class, 'store'])->name('voucher.contra.store');
        Route::get('/contra/edit/{id}', [ContraVoucherController::class, 'edit'])->name('voucher.contra.edit');
        Route::put('/contra/update/{id}', [ContraVoucherController::class, 'update'])->name('voucher.contra.update');
        Route::delete('/contra/delete/{id}', [ContraVoucherController::class, 'destroy'])->name('voucher.contra.delete');
        Route::get('/contra/toggle-status/{id}', [ContraVoucherController::class, 'toggleStatus'])->name('voucher.contra.toggle-status');
    
    });
    
     // Voucher Entry (Legacy)
     Route::prefix('reports')->group(function () { 
         Route::get('/journal-report', [AccountReportsController::class, 'journalReport'])->name('reports.journal-report');
         Route::post('/journal-report-data', [AccountReportsController::class, 'journalReportGetData'])->name('reports.journal-report-data');
         Route::get('/lager-report', [AccountReportsController::class, 'lagerReport'])->name('reports.lager-report');
        Route::post('/lager-report-data', [AccountReportsController::class, 'lagerReportGetData'])->name('reports.lager-report-data');
         Route::get('/balance-sheet-report', [AccountReportsController::class, 'balanceSheetReport'])->name('reports.balance-sheet-report');
         Route::post('/balance-sheet-report-data', [AccountReportsController::class, 'balanceSheetReportGetData'])->name('reports.balance-sheet-report-data');
         Route::get('/income-statement-report', [AccountReportsController::class, 'incomeStatementReport'])->name('reports.income-statement-report');
         Route::post('/income-statement-report-data', [AccountReportsController::class, 'incomeStatementReportGetData'])->name('reports.income-statement-report-data');
       });


    // Chart of Accounts
    Route::get('/chart-of-accounts', [ChartOfAccountsController::class, 'index'])->name('chart-of-accounts.index');
    
    // Payment Voucher (Direct route for sidebar)
    Route::get('/payment-voucher', [PaymentVoucherController::class, 'index'])->name('payment-voucher.index');
    Route::get('/payment-voucher/create', [PaymentVoucherController::class, 'create'])->name('payment-voucher.create');
    Route::post('/payment-voucher/store', [PaymentVoucherController::class, 'store'])->name('payment-voucher.store');
    Route::get('/payment-voucher/edit/{id}', [PaymentVoucherController::class, 'edit'])->name('payment-voucher.edit');
    Route::put('/payment-voucher/update/{id}', [PaymentVoucherController::class, 'update'])->name('payment-voucher.update');
    Route::delete('/payment-voucher/destroy/{id}', [PaymentVoucherController::class, 'destroy'])->name('payment-voucher.destroy');
    Route::get('/payment-voucher/show/{id}', [PaymentVoucherController::class, 'show'])->name('payment-voucher.show');
    Route::get('/payment-voucher/print/{id}', [PaymentVoucherController::class, 'print'])->name('payment-voucher.print');
    
    // Contra Voucher Routes
    Route::get('/contra-voucher', [ContraVoucherController::class, 'index'])->name('contra-voucher.index');
    Route::get('/contra-voucher/create', [ContraVoucherController::class, 'create'])->name('contra-voucher.create');
    Route::post('/contra-voucher/store', [ContraVoucherController::class, 'store'])->name('contra-voucher.store');
    Route::get('/contra-voucher/edit/{id}', [ContraVoucherController::class, 'edit'])->name('contra-voucher.edit');
    Route::put('/contra-voucher/update/{id}', [ContraVoucherController::class, 'update'])->name('contra-voucher.update');
    Route::delete('/contra-voucher/destroy/{id}', [ContraVoucherController::class, 'destroy'])->name('contra-voucher.destroy');
    Route::get('/contra-voucher/show/{id}', [ContraVoucherController::class, 'show'])->name('contra-voucher.show');
    Route::get('/contra-voucher/print/{id}', [ContraVoucherController::class, 'print'])->name('contra-voucher.print');
    
    // Journal Voucher Routes
    Route::get('/journal-voucher', [JournalVoucherController::class, 'index'])->name('voucher.journal');
    Route::get('/journal-voucher/create', [JournalVoucherController::class, 'create'])->name('voucher.journal.create');
    Route::post('/journal-voucher/store', [JournalVoucherController::class, 'store'])->name('voucher.journal.store');
    Route::get('/journal-voucher/edit/{id}', [JournalVoucherController::class, 'edit'])->name('voucher.journal.edit');
    Route::put('/journal-voucher/update/{id}', [JournalVoucherController::class, 'update'])->name('voucher.journal.update');
    Route::delete('/journal-voucher/destroy/{id}', [JournalVoucherController::class, 'destroy'])->name('voucher.journal.destroy');
    Route::get('/journal-voucher/show/{id}', [JournalVoucherController::class, 'show'])->name('voucher.journal.show');
    Route::get('/journal-voucher/print/{id}', [JournalVoucherController::class, 'print'])->name('voucher.journal.print');
    Route::get('/journal-voucher/report', [JournalVoucherController::class, 'report'])->name('voucher.journal.report');
    
    // Test route
    Route::get('/test-payment-voucher', function() {
        try {
            if (\Schema::hasTable('payment_vouchers')) {
                return response()->json(['status' => 'success', 'message' => 'Table exists']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Table does not exist']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    });
});
