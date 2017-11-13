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
    * Abstract class that will be used to set the fields that differ in all the children
    */
    // abstract protected function setFields();

    /*
    * Gets the various properties belonging to a payment
    */
    protected function getFields()
    {
        return collect(get_object_vars($this))->forget('mode')->toArray();
    }

}