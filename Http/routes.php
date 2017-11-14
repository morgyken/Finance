<?php

//old web routes
use Illuminate\Routing\Router;

$router->get('jambo', function (\Ignite\Finance\Repositories\Jambo $jambo) {
    dd($jambo->createWalletForPatient(\Ignite\Reception\Entities\Patients::find(3)));
});
///Billing finance.billing.dispatch
/** @var Router $router */
$router->match(['get', 'post'], 'billing', ['uses' => 'FinanceController@billing', 'as' => 'billing']);
$router->match(['get', 'post'], 'billing/dispatch', ['uses' => 'GlController@dispatchbills', 'as' => 'billing.dispatch']);
$router->get('bill/{id}/cancel', ['uses' => 'GlController@cancelBill', 'as' => 'bill.cancel']);
$router->get('bill/{id}/payment', ['uses' => 'GlController@payBill', 'as' => 'bill.pay']);
$router->post('bill/payment', ['uses' => 'GlController@savePaybill', 'as' => 'bill.pay.save']);
$router->get('bill/print/{id}', ['uses' => 'GlController@print_bill', 'as' => 'bill.print']);
$router->get('change-mode/{id}/visit/{split?}', ['as' => 'change_mode', 'uses' => 'FinanceController@changeMode']);
$router->get('split-bill/{id}/visit/{split?}', ['as' => 'split_bill', 'uses' => 'FinanceController@splitBill']);
$router->get('pos/cash/{patient?}/{invoice?}/{deposit?}', ['as' => 'pos_cash', 'uses' => 'EvaluationController@payPOS']);
$router->get('invoice/view/{inv}/show', ['as' => 'view_invoice_bill', 'uses' => 'FinanceController@invoiceInfo']);

// general ledger
// general ledger
$router->group(['prefix' => 'gl', 'as' => 'gl.'], function (Router $router) {
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

$router->group(['prefix' => 'self-accounts', 'as' => 'account.'], function (Router $router) {
    $router->get('patients', ['uses' => 'FinanceController@list', 'as' => 'list']);
    $router->get('deposit/{id}/request', ['uses' => 'FinanceController@deposit', 'as' => 'deposit']);
    $router->get('deposit/{id}/done', ['uses' => 'FinanceController@doneDeposit', 'as' => 'deposit.done']);
    $router->post('deposit/{id}/do', ['uses' => 'FinanceController@saveDeposit', 'as' => 'deposit.save']);
});
//financials
$router->group(['prefix' => 'evaluation', 'as' => 'evaluation.'], function (Router $router) {
    $router->post('pharmacy/dispense', ['uses' => 'EvaluationController@pharmacy_dispense', 'as' => 'pharmacy.dispense']);
    $router->get('pay/{patient?}/{invoice?}/{deposit?}', ['as' => 'pay', 'uses' => 'EvaluationController@pay']);
    $router->get('pharmacy/{patient?}/{insurance?}/{split?}', ['as' => 'pay.pharmacy', 'uses' => 'EvaluationController@payPharmacy']);
    $router->match(['get', 'post'], 'invoice/{patient?}', ['uses' => 'EvaluationController@patient_invoice', 'as' => 'invoice']);

    $router->get('patient/invoices/{id?}', ['uses' => 'EvaluationController@manage_patient_invoices', 'as' => 'patient_invoices']);
    $router->get('patient/invoices/{id}/purge', ['uses' => 'EvaluationController@purge_patient_invoice', 'as' => 'purge_patient_invoice']);
    $router->get('patient/invoices/{id}/print', ['uses' => 'EvaluationController@print_patient_invoice', 'as' => 'patient_invoice.print']);


    $router->get('sale/pay/{sale?}', ['as' => 'sale.pay', 'uses' => 'EvaluationController@sale_pay']);
    $router->get('sale/details/{sale}', ['uses' => 'EvaluationController@sale_details', 'as' => 'sale']);
    //Remove Bill
    //$router->get('bill/sale/remove/{id?}/', ['uses' => 'EvaluationController@RemoveSaleBill', 'as' => 'remove.sale_bill']);
    $router->post('bill/remove/', ['uses' => 'EvaluationController@RemoveBill', 'as' => 'remove.bill']);

    $router->get('accounts/{patient}/show', ['uses' => 'EvaluationController@individual_account', 'as' => 'individual_account']);

    $router->post('payment', ['as' => 'pay.save', 'uses' => 'EvaluationController@pay_save']);
    $router->get('payment_details/{id}/{invoice?}', ['as' => 'payment_details', 'uses' => 'EvaluationController@payment_details']);
    $router->get('summary', ['as' => 'summary', 'uses' => 'EvaluationController@summary']);
    $router->get('insurance', ['as' => 'insurance', 'uses' => 'EvaluationController@insurance']);
    $router->get('cash_bills', ['as' => 'cash_bills', 'uses' => 'EvaluationController@cash_bills']);

    $router->get('bill/prepare/{id}/{split?}', ['as' => 'prepare.bill', 'uses' => 'EvaluationController@preparebill']);
    $router->post('bill/{visit}/panda', ['as' => 'bill', 'uses' => 'FinanceController@bill']);
    $router->post('bill/{visit}/swap', ['as' => 'swap.mode', 'uses' => 'FinanceController@swapModes']);
    $router->post('bill/{visit}/split', ['as' => 'split', 'uses' => 'FinanceController@saveSplitBill']);
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
    $router->get('tocash/{visit}', ['as' => 'tocash', 'uses' => 'EvaluationController@billToCash']);
    $router->get('payment', ['as' => 'payment', 'uses' => 'EvaluationController@companyInvoicePayment']);
    $router->get('paid/ins/invoices', ['as' => 'paid', 'uses' => 'EvaluationController@paidInvoices']);

    $router->get('print/insurance/invoice/{id}/dharma', ['as' => 'ins.inv.print_thermal', 'uses' => 'FinanceController@printThermalInvoice']);
    $router->get('print/insurance/invoice/{id}/print', ['as' => 'ins.inv.print', 'uses' => 'EvaluationController@printInvoice']);
    $router->get('print/insurance/receipt/{id}', ['as' => 'ins.rcpt.print', 'uses' => 'EvaluationController@printReceipt']);

    $router->post('print/receipt/thermal', ['as' => 'normal.rcpt.print', 'uses' => 'EvaluationController@printNormalReceipt']);
    $router->post('print/receipt/a4/', ['as' => 'a4.rcpt.print', 'uses' => 'EvaluationController@printA4Receipt']);

    $router->get('print/dispatch/{id}', ['as' => 'print_dispatch', 'uses' => 'EvaluationController@printDispatch']);
    $router->get('purge/dispatch/{id}', ['as' => 'purge_dispatch', 'uses' => 'EvaluationController@purgeDispatch']);

    $router->get('company/statements', ['as' => 'company.stmt', 'uses' => 'EvaluationController@companyStatements']);
});
//$router->get('pharmacy/')
$router->group(['prefix' => 'quickbooks', 'as' => 'quickbooks.'], function (Router $router) {
    $router->get('quickbooks/connect', ['as' => 'connect', 'uses' => 'QuickBooksController@index']);
    $router->get('quickbooks/oauth', ['as' => 'oauth', 'uses' => 'QuickBooksController@qboOauth']);
    $router->get('quickbooks/success', ['as' => 'success', 'uses' => 'QuickBooksController@qboSuccess']);
    $router->get('quickbooks/disconnect', ['as' => 'disconnect', 'uses' => 'QuickBooksController@qboDisconnect']);
    $router->get('quickbooks/create-user', ['as' => 'create_user', 'uses' => 'QuickBooksController@createCustomer']);
});
