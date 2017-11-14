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
     * @return mixed
     */
    public function createWalletForPatient(Patients $patient);
}