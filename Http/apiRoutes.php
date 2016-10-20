
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

$ajax = [
    'namespace' => 'Dervis\Modules\Finance\Http\Controllers',
    'as' => 'finance.ajax.',
    'prefix' => 'finance/ajax',
    'middleware' => ['ajax'],
];
//AJAX ONLY routes
Route::group($ajax, function() {
    Route::get('accounts', ['uses' => 'APIController@bankAccounts', 'as' => 'accounts']);
    Route::get('check/bogus/widthrawal', ['uses' => 'APIController@checkBogusWidthrawal', 'as' => 'widthraw.bogus']);
});
