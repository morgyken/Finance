<?php

namespace Ignite\Finance\Library\PatientAccounts;

use Ignite\Finance\Entities\PaymentsCheque;

use Ignite\Finance\Library\PatientAccounts\Contracts\PaymentMode;

class Cheque extends Payment implements PaymentMode
{
    /*
    * Determines the type of the class contractor
    */
    public $mode = "cheque";

    protected $name, $bank, $number;

    /*
    * Constructor receives all the values and sets them accordingly
    */
    public function __construct($details, $paymentId)
    {
        parent::__construct($details, $paymentId);

        $this->name = $details['name'];
        
        $this->bank = $details['bank']; 
        
        $this->number = $details['number'];
    }

    /*
    * Save a cash deposit into the database
    */
    public function save()
    {
        PaymentsCheque::create($this->getFields());

        return $this->amount;
    }
}