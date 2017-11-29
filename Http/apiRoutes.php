<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

use Illuminate\Routing\Router;

/** @var Router $router */

$router->get('accounts', ['uses' => 'APIController@bankAccounts', 'as' => 'accounts']);
$router->get('check/bogus/widthrawal', ['uses' => 'APIController@checkBogusWidthrawal', 'as' => 'widthraw.bogus']);
$router->get('jp/check_wallet_exist/{patient_id}/jambopay', ['as' => 'wallet.check', 'uses' => 'APIController@checkWalletExist']);
$router->get('jp/create_wallet/{patient_id}/jambopay', ['as' => 'wallet.create', 'uses' => 'APIController@createWallet']);
$router->post('jp/check_status/{patient_id}/jambopay', ['as' => 'wallet.status', 'uses' => 'APIController@getBillStatus']);
$router->post('jp/wallet/post/{patient_id}/jambopay', ['as' => 'wallet.post', 'uses' => 'APIController@postBill']);
$router->get('jp/bills/{patient_id}/pending', ['as' => 'wallet.pending', 'uses' => 'APIController@getPendingBills']);
//financials
$router->group(['prefix' => 'evaluation.billing', 'as' => 'evaluation.'], function (Illuminate\Routing\Router $router) {
    $router->get('fetchinvoices', ['uses' => 'BillingApiController@fetchInvoices', 'as' => 'firm.invoices']);
    $router->get('bill/remove/', ['uses' => 'APIController@RemoveBill', 'as' => 'bill.remove']);
    $router->get('bill/remove/undo', ['uses' => 'APIController@UndoRemoveBill', 'as' => 'bill.undoremove']);
});


