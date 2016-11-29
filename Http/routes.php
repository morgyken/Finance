<?php

//old web routes
use Illuminate\Routing\Router;

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

    $router->get('bill/{id}', ['as' => 'bill', 'uses' => 'EvaluationController@bill']);
    $router->post('bill/insurances', ['as' => 'bill.many', 'uses' => 'EvaluationController@billMany']);

    $router->get('insurance/payment', ['as' => 'insurance.payment', 'uses' => 'EvaluationController@insurancePayment']);
    $router->get('insurance/payment/specific/{id}', ['as' => 'insurance.payment.specific', 'uses' => 'EvaluationController@insurancePayment']);

    $router->get('cancel/{id}', ['as' => 'cancel', 'uses' => 'EvaluationController@cancelBill']);
    $router->post('dispatch', ['as' => 'dispatch', 'uses' => 'EvaluationController@dispatchBill']);
    $router->get('ins/payment/{visit}', ['as' => 'ins.pay', 'uses' => 'EvaluationController@payInsBill']);
    $router->post('ins/payment', ['as' => 'ins.save.pay', 'uses' => 'EvaluationController@saveInsuranceInvoicePayments']);

    $router->get('pending/bills', ['as' => 'pending', 'uses' => 'EvaluationController@pendingBills']);
    $router->get('billed/invoices', ['as' => 'billed', 'uses' => 'EvaluationController@billedBills']);
    $router->get('dispatched/invoices', ['as' => 'dispatched', 'uses' => 'EvaluationController@dispatchedInvoices']);
    $router->get('cancelled', ['as' => 'cancelled', 'uses' => 'EvaluationController@cancelledBills']);
    $router->get('cancell/undo/{id}', ['as' => 'undo.cancel', 'uses' => 'EvaluationController@undoBillCancel']);
    $router->get('payment', ['as' => 'payment', 'uses' => 'EvaluationController@companyInvoicePayment']);
    $router->get('paid/ins/invoices', ['as' => 'paid', 'uses' => 'EvaluationController@paidInvoices']);

    $router->get('print/insurance/invoice/{id}', ['as' => 'ins.inv.print', 'uses' => 'EvaluationController@printInvoice']);
    $router->get('print/insurance/receipt/{id}', ['as' => 'ins.rcpt.print', 'uses' => 'EvaluationController@printReceipt']);

    $router->get('company/statements', ['as' => 'company.stmt', 'uses' => 'EvaluationController@companyStatements']);
});
