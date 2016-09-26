<?php

$params = [
    'middleware' => ['auth.admin', 'setup'],
    'prefix' => 'finance',
    'as' => 'finance.',
    'namespace' => 'Ignite\Finance\Http\Controllers'];

Route::group($params, function() {
    //old web routes
    Route::get('/', ['uses' => 'FinanceController@index', 'as' => 'index']);
    Route::get('patients/accounts', ['uses' => 'FinanceController@patient_accounts', 'as' => 'patient_accounts']);
    Route::get('patients/accounts/individual/{patient}', ['uses' => 'FinanceController@individual_account', 'as' => 'individual_account']);
    Route::match(['get', 'post'], 'patients/payments/receive/{patient?}', ['uses' => 'FinanceController@receive_payments', 'as' => 'receive_payments']);
    Route::get('insurance', ['uses' => 'FinanceController@insurance', 'as' => 'insurance']);
    Route::get('finance/deposits/{patient}', ['uses' => 'FinanceController@deposits', 'as' => 'deposits']);
    Route::get('payment_details/{ref}', ['uses' => 'FinanceController@payment_details', 'as' => 'payment_details']);
    Route::get('workbench/{area?}', ['uses' => 'FinanceController@workbench', 'as' => 'workbench']);


    // general ledger
    Route::group(['prefix' => 'gl', 'as' => 'gl.'], function() {
        Route::match(['get', 'post'], 'account_groups/{id?}', ['uses' => 'GlController@account_groups', 'as' => 'account_groups']);
        Route::match(['get', 'post'], 'account_types/{id?}', ['uses' => 'GlController@account_types', 'as' => 'account_types']);
        Route::match(['get', 'post'], 'accounts/{id?}', ['uses' => 'GlController@accounts', 'as' => 'accounts']);

        Route::match(['get', 'post'], 'banks', ['uses' => 'GlController@bank', 'as' => 'banks']);
        Route::match(['get', 'post'], 'banks/{id}/trash', ['uses' => 'GlController@bankDelete', 'as' => 'banks.del']);
        Route::match(['get', 'post'], 'banks/edit/{id}', ['uses' => 'GlController@bankEdit', 'as' => 'bank.edit']);
        Route::match(['get', 'post'], 'banking', ['uses' => 'GlController@banking', 'as' => 'banking']);
        Route::match(['get', 'post'], 'banking/{id}/trash', ['uses' => 'GlController@banking_trash', 'as' => 'banking.trash']);
        Route::match(['get', 'post'], 'banking/accounts', ['uses' => 'GlController@bankAccount', 'as' => 'bank.accounts']);
        Route::match(['get', 'post'], 'banking/accounts/edit/{id}', ['uses' => 'GlController@bankAccountEdit', 'as' => 'bank.account.edit']);
        Route::match(['get', 'post'], 'banking/accounts/trash/{id}', ['uses' => 'GlController@bankAccountDelete', 'as' => 'bank.account.del']);
        Route::match(['get', 'post'], 'pettycash', ['uses' => 'GlController@pettyCash', 'as' => 'pettycash']);
        Route::match(['get', 'post'], 'payment/save', ['uses' => 'GlController@payment', 'as' => 'save.payment']);
        Route::match(['get', 'post'], 'payments', ['uses' => 'GlController@payments', 'as' => 'inv.payments']);
        Route::match(['get', 'post'], 'payment/{id}', ['uses' => 'GlController@payments', 'as' => 'payment.details']);
    });
});
