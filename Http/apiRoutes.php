
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

//financials
$router->group(['prefix' => 'evaluation.billing', 'as' => 'evaluation.'], function(Illuminate\Routing\Router $router) {
    $router->get('fetchinvoices', ['uses' => 'BillingApiController@fetchInvoices', 'as' => 'firm.invoices']);
    $router->get('bill/remove/', ['uses' => 'APIController@RemoveBill', 'as' => 'bill.remove']);
    $router->get('bill/remove/undo', ['uses' => 'APIController@UndoRemoveBill', 'as' => 'bill.undoremove']);
});


