<?php

namespace Ignite\Finance\Library\PatientAccounts;

use Ignite\Reception\Entities\Patients;

use Ignite\Finance\Library\PatientAccounts\Contracts\PaymentMode;

class PatientAccount
{
    /**
    *@var Represents the balance that the patient has
    */

    protected $patient, $account, $balance;

    /*
    * Inject teh various dependencies that are needed
    */
    public function __construct(Patients $patient)
    {
        $this->patient = $patient;

        $this->account = $this->openAccount();

        $this->balance = $this->account->balance;
        
    }

    /*
    *  sets the overall 
    */
    public function deposit(PaymentMode $mode)
    {
        $this->account->balance = $this->balance + $mode->save();
        
        $this->account->save();

        $this->balance = $this->account->balance;

        return $this;
    }

    /*
    * Returns the total balance within the patient account
    */
    public function balance()
    {
        return $this->balance;
    }

    /*
    * Register a new account for the patient
    */
    public function openAccount()
    {
        return \Ignite\Finance\Entities\PatientAccount::firstOrCreate([

            'patient' => $this->patient->id

        ]);
    }
}