<?php

namespace Ignite\Finance\Library\PatientAccounts;

use Ignite\Finance\Entities\PaymentsCash;

use Ignite\Finance\Library\PatientAccounts\Contracts\PaymentMode;

class Cash extends Payment implements PaymentMode
{
    public $mode = "cash";

    /*
    * Constructor receives all the values and sets them accordingly
    */
    public function __construct($details, $paymentId)
    {
        parent::__construct($details, $paymentId);
    }

    /*
    * Save a cash deposit into the database
    */
    public function save()
    {
        PaymentsCash::create($this->getFields());

        return $this->amount;
    }
}