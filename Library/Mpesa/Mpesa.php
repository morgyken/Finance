<?php

namespace Ignite\Finance\Library\Mpesa;


use Illuminate\Support\Facades\Facade;

/**
 * Class Mpesa
 * @package Ignite\Finance\Library\Mpesa
 */
class Mpesa extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pesa';
    }
}