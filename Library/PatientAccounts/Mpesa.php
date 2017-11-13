<?php

namespace Ignite\Finance\Library\PatientAccounts;

use Ignite\Finance\Entities\PaymentsMpesa;

use Ignite\Finance\Library\PatientAccounts\Contracts\PaymentMode;

class Mpesa extends Payment implements PaymentMode
{
    /*
    * Determines the type of the class contractor
    */
    public $mode = "mpesa";

    protected $reference;

    /*
    * Constructor receives all the values and sets them accordingly
    */
    public function __construct($details, $paymentId)
    {
        parent::__construct($details, $paymentId);

        $this->reference = $details['reference'];
    }

    /*
    * Save a cash deposit into the database
    */
    public function save()
    {
        PaymentsMpesa::create($this->getFields());

        return $this->amount;
    }
}