<?php

namespace Ignite\Finance\Repositories;

use Ignite\Reception\Entities\Patients;

/**
 * Interface Jambo
 * @package Ignite\Finance\Repositories
 */
interface Jambo
{

    /**
     * @param Patients $patient
     * @return mixed
     */
    public function checkPatientHasWallet(Patients $patient);

    /**
     * @param Patients $patient
     * @param string|null $pin
     * @return mixed
     */
    public function createWalletForPatient(Patients $patient, $pin = null);

    /**
     * @param Patients $patient
     * @param int $amount
     * @param string $narrative
     * @return mixed
     */
    public function postBillForPatient(Patients $patient, $amount, $narrative);

    /**
     * @param Patients $patients
     * @param string $bill_number
     * @return mixed
     */
    public function getBillStatus(Patients $patients, $bill_number);
}