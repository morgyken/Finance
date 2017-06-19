<?php

namespace Ignite\Finance\Library\Mpesa\Exceptions;

/**
 * Class InvalidRequestException
 * @package Ignite\Finance\Library\Mpesa\Exceptions
 */
class InvalidRequestException extends \Exception
{
    /**
     * Errors
     */
    const ERRORS = [
        'E_PAYBILL' => 'The Paybill Number is required',
        'E_PASSWORD' => 'The Password is required',
        'E_TIMESTAMP' => 'The Timestamp is required',
        'E_TRANS_ID' => 'The Transaction ID is required',
        'E_REF_ID' => 'The Reference ID is required',
        'E_AMOUNT' => 'The Transaction Amount is required',
        'E_NUMBER' => 'The Mobile Number is required',
        'E_CALL_URL' => 'The Callback URL is required',
        'E_CALL_METHOD' => 'The Callback Method is required',
    ];
}