<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\LedgerController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\ExpenseController;
use App\Http\Controllers\Account\PaymenttypeController;
use App\Http\Controllers\Account\TransactionController;
use App\Http\Controllers\Account\ExpenseCategoryController;


Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {
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
});
