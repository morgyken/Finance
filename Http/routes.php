<?php

//old web routes
use Illuminate\Routing\Router;

$router->get('/', ['uses' => 'FinanceController@index', 'as' => 'index']);
$router->get('patients/accounts', ['uses' => 'FinanceController@patient_accounts', 'as' => 'patient_accounts']);
$router->get('patients/accounts/individual/{patient}', ['uses' => 'FinanceController@individual_account', 'as' => 'individual_account']);
$router->match(['get', 'post'], 'patients/payments/receive/{patient?}', ['uses' => 'FinanceController@receive_payments', 'as' => 'receive_payments']);
$router->get('insurance', ['uses' => 'FinanceController@insurance', 'as' => 'insurance']);
$router->get('finance/deposits/{patient}', ['uses' => 'FinanceController@deposits', 'as' => 'deposits']);
$router->get('payment_details/{ref}', ['uses' => 'FinanceController@payment_details', 'as' => 'payment_details']);
$router->get('workbench/{area?}', ['uses' => 'FinanceController@workbench', 'as' => 'workbench']);
///Billing finance.billing.dispatch
$router->match(['get', 'post'], 'billing', ['uses' => 'FinanceController@billing', 'as' => 'billing']);
$router->match(['get', 'post'], 'billing/dispatch', ['uses' => 'GlController@dispatchbills', 'as' => 'billing.dispatch']);
$router->get('bill/{id}/cancel', ['uses' => 'GlController@cancelBill', 'as' => 'bill.cancel']);
$router->get('bill/{id}/payment', ['uses' => 'GlController@payBill', 'as' => 'bill.pay']);
$router->post('bill/payment', ['uses' => 'GlController@savePaybill', 'as' => 'bill.pay.save']);
$router->get('bill/print/{id}', ['uses' => 'GlController@print_bill', 'as' => 'bill.print']);
// general ledger
$router->group(['prefix' => 'gl', 'as' => 'gl.'], function(Router $router) {
    $router->match(['get', 'post'], 'account_groups/{id?}', ['uses' => 'GlController@account_groups', 'as' => 'account_groups']);
    $router->match(['get', 'post'], 'account_types/{id?}', ['uses' => 'GlController@account_types', 'as' => 'account_types']);
    $router->match(['get', 'post'], 'accounts/{id?}', ['uses' => 'GlController@accounts', 'as' => 'accounts']);
///Banking
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

//financials
$router->group(['prefix' => 'evaluation', 'as' => 'evaluation.'], function(Illuminate\Routing\Router $router) {
    $router->get('pay/{patient?}', ['as' => 'pay', 'uses' => 'EvaluationController@pay']);
    $router->get('accounts', ['uses' => 'EvaluationController@accounts', 'as' => 'accounts']);
    $router->get('accounts/{patient}/show', ['uses' => 'EvaluationController@individual_account', 'as' => 'individual_account']);
    $router->post('payment', ['as' => 'pay.save', 'uses' => 'EvaluationController@pay_save']);
    $router->get('payment_details/{id}', ['as' => 'payment_details', 'uses' => 'EvaluationController@payment_details']);
    $router->get('summary', ['as' => 'summary', 'uses' => 'EvaluationController@summary']);
    $router->get('insurance', ['as' => 'insurance', 'uses' => 'EvaluationController@insurance']);
    $router->get('cash_bills', ['as' => 'cash_bills', 'uses' => 'EvaluationController@cash_bills']);
});
