
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

