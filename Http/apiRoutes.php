
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

$router->get('accounts', ['uses' => 'APIController@bankAccounts', 'as' => 'accounts']);
$router->get('check/bogus/widthrawal', ['uses' => 'APIController@checkBogusWidthrawal', 'as' => 'widthraw.bogus']);

//financials
$router->group(['prefix' => 'evaluation.billing', 'as' => 'evaluation.'], function(Illuminate\Routing\Router $router) {
    $router->get('fetchinvoices', ['uses' => 'BillingApiController@fetchInvoices', 'as' => 'firm.invoices']);
});


