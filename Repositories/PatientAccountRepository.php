<?php
namespace Ignite\Finance\Repositories;

use Ignite\Reception\Entities\Patients;

use Ignite\Finance\Library\PatientAccounts\PatientAccount;

class PatientAccountRepository
{
    /*
    * Get a patient given an di
    */
    public function find($patientId)
    {
        return Patients::with(['account'])->findOrFail($patientId);
    }

    /*
    * Save the balance(s) for a particular patient
    */
    public function deposit($paymentId)
    {
        $payments = request()->except(['_token', 'payment_type', 'patient']);

        $patient = $this->find(request()->get('patient'));

        return $this->creditPatientAccount($patient, $payments, $paymentId);
    }

    /*
    * Gets the patient account and credits it based on various payment modes
    * Returns the total deposit that has been put in the patients account
    */
    public function creditPatientAccount($patient, $payments, $paymentId)
    {
        $account = new PatientAccount($patient);

        foreach($payments as $mode => $details)
        {
            $class = $this->getPaymentModeClass($mode);

            if(isset($details['amount']) and is_numeric($details['amount']))
            {
                $account->deposit(new $class($details, $paymentId));
            }
        }

        return $account->balance();
    }

    /*
    * Helper to get the name of the class that represents a payment mode
    */
    public function getPaymentModeClass($mode)
    {
        $className = ucwords($mode);

        return "Ignite\Finance\Library\PatientAccounts\\$className";
    }


}