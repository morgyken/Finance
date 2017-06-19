<?php

namespace Ignite\Finance\Library\Mpesa;

use Ignite\Finance\Library\Mpesa\Exceptions\InvalidRequestException;

/**
 * Class Validator
 * @package Ignite\Finance\Library\Mpesa
 */
class Validator
{
  
    const RULES = [
        'E_PAYBILL',
        'E_PASSWORD',
        'E_TIMESTAMP',
        'E_TRANS_ID',
        'E_REF_ID',
        'E_AMOUNT',
        'E_NUMBER',
        'E_CALL_URL',
        'E_CALL_METHOD'
    ];

    /**
     * Check if key exists else throw exception.
     *
     * @param array $data
     *
     * @throws InvalidRequestException
     */
    public static function validate($data = [])
    {
        foreach (static::RULES as $value) {
            if (! array_key_exists($value, $data)) {
                throw new InvalidRequestException(InvalidRequestException::ERRORS[$value]);
            }
        }
    }
}