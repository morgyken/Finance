<?php

//old web routes
$router->get('/', ['uses' => 'FinanceController@index', 'as' => 'index']);
$router->get('patients/accounts', ['uses' => 'FinanceController@patient_accounts', 'as' => 'patient_accounts']);
$router->get('patients/accounts/individual/{patient}', ['uses' => 'FinanceController@individual_account', 'as' => 'individual_account']);
$router->match(['get', 'post'], 'patients/payments/receive/{patient?}', ['uses' => 'FinanceController@receive_payments', 'as' => 'receive_payments']);
$router->get('insurance', ['uses' => 'FinanceController@insurance', 'as' => 'insurance']);
$router->get('finance/deposits/{patient}', ['uses' => 'FinanceController@deposits', 'as' => 'deposits']);
$router->get('payment_details/{ref}', ['uses' => 'FinanceController@payment_details', 'as' => 'payment_details']);
$router->get('workbench/{area?}', ['uses' => 'FinanceController@workbench', 'as' => 'workbench']);


// general ledger
$router->group(['prefix' => 'gl', 'as' => 'gl.'], function(Illuminate\Routing\Router $router) {
    $router->match(['get', 'post'], 'account_groups/{id?}', ['uses' => 'GlController@account_groups', 'as' => 'account_groups']);
    $router->match(['get', 'post'], 'account_types/{id?}', ['uses' => 'GlController@account_types', 'as' => 'account_types']);
    $router->match(['get', 'post'], 'accounts/{id?}', ['uses' => 'GlController@accounts', 'as' => 'accounts']);

    $router->match(['get', 'post'], 'banks', ['uses' => 'GlController@bank', 'as' => 'banks']);
    $router->match(['get', 'post'], 'banks/{id}/trash', ['uses' => 'GlController@bankDelete', 'as' => 'banks.del']);
    $router->match(['get', 'post'], 'banks/edit/{id}', ['uses' => 'GlController@bankEdit', 'as' => 'bank.edit']);
    $router->match(['get', 'post'], 'banking', ['uses' => 'GlController@banking', 'as' => 'banking']);
    $router->match(['get', 'post'], 'banking/{id}/trash', ['uses' => 'GlController@banking_trash', 'as' => 'banking.trash']);
    $router->match(['get', 'post'], 'banking/accounts', ['uses' => 'GlController@bankAccount', 'as' => 'bank.accounts']);
    $router->match(['get', 'post'], 'banking/accounts/edit/{id}', ['uses' => 'GlController@bankAccountEdit', 'as' => 'bank.account.edit']);
    $router->match(['get', 'post'], 'banking/accounts/trash/{id}', ['uses' => 'GlController@bankAccountDelete', 'as' => 'bank.account.del']);
    $router->match(['get', 'post'], 'pettycash', ['uses' => 'GlController@pettyCash', 'as' => 'pettycash']);
    $router->match(['get', 'post'], 'payment/save', ['uses' => 'GlController@payment', 'as' => 'save.payment']);
    $router->match(['get', 'post'], 'payments', ['uses' => 'GlController@payments', 'as' => 'inv.payments']);
    $router->match(['get', 'post'], 'payment/{id}', ['uses' => 'GlController@payments', 'as' => 'payment.details']);
});
