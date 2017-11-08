<?php

namespace Ignite\Finance\Library\PatientAccounts;

use Ignite\Finance\Entities\PaymentsCard;

use Ignite\Finance\Library\PatientAccounts\Contracts\PaymentMode;

class Card extends Payment implements PaymentMode
{
    /*
    * Determines the type of the class contractor
    */
    public $mode = "card";

    protected $name, $number, $expiry, $type;

    /*
    * Constructor receives all the values and sets them accordingly
    */
    public function __construct($details, $paymentId)
    {
        parent::__construct($details, $paymentId);

        $this->type = $details['type'];

        $this->name = $details['name'];

        $this->number = $details['number']; 
        
        $this->expiry = $details['expiry'];
    }

    /*
    * Save a cash deposit into the database
    */
    public function save()
    {
        PaymentsCard::create($this->getFields());

        return $this->amount;
    }
}