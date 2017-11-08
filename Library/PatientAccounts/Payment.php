<?php

namespace Ignite\Finance\Library\PatientAccounts;

class Payment
{
    protected $amount, $payment;

    /*
    * Initialises the amount needed 
    */
    public function __construct($details, $paymentId)
    {
        $this->amount = $details['amount'];

        $this->payment = $paymentId;
    }

    /*
    * Gets the various properties belonging to a payment
    */
    public function getFields()
    {
        return collect(get_object_vars($this))->forget('mode')->toArray();
    }

}