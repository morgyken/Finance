<?php

namespace Ignite\Finance\Library\Mpesa;

use Ignite\Finance\Library\Mpesa\Repository\MpesaRepository;

/**
 * Class MpesaInitializer
 * @package Ignite\Finance\Library\Mpesa
 */
class MpesaInitializer implements MpesaRepository
{
    /**
     * The M-Pesa API Endpoint.
     *
     * @var string
     */
    public $endpoint;

    /**
     * The callback URL to be queried on transaction completion.
     *
     * @var string
     */
    public $callbackUrl;

    /**
     * The callback method to be used.
     *
     * @var string
     */
    public $callbackMethod;

    /**
     * The merchant's Paybill number.
     *
     * @var int
     */
    public $paybillNumber;

    /**
     * The SAG Passkey given on registration.
     *
     * @var string
     */
    public $passkey;

    /**
     * Set the system to use demo timestamp and password.
     *
     * @var bool
     */
    public $demo;


    /**
     * Boot up the instance.
     */
    public function __construct()
    {
        $this->setupBroker();
        $this->setupPaybill();
    }

    /**
     * Set up the API Broker endpoint and callback
     */
    protected function setupBroker()
    {
        $this->endpoint = mconfig('finance.mpesa.endpoint');
        $this->callbackUrl = mconfig('finance.mpesa.callback_url');
        $this->callbackMethod = mconfig('finance.mpesa.callback_method');
    }

    /**
     * Set up Merchant Paybill account.
     */
    protected function setupPaybill()
    {
        $this->paybillNumber = mconfig('finance.mpesa.paybill_number');
        $this->passkey = mconfig('finance.mpesa.passkey');
        $this->demo = mconfig('finance.mpesa.demo');
    }
}