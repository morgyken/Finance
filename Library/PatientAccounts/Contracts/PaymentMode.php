<?php

namespace Ignite\Finance\Library\PatientAccounts\Contracts;

interface PaymentMode
{
    /*
    * Persists the payment amount to storage
    */
    public function save();
}