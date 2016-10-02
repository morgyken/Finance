<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Finance\Entities;

use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Schemes;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PatientPayments
 *
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Settings\Entities\Schemes $schemes
 * @property-read mixed $total
 * @property-read mixed $modes
 * @mixin \Eloquent
 */
class PatientPayments extends Model {

    //  public $primaryKey = 'patient_payments';

    public function patients() {
        return $this->belongsTo(Patients::class, 'patient', 'patient_id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user', 'user_id');
    }

    public function schemes() {
        return $this->belongsTo(Schemes::class, 'scheme', 'scheme_id');
    }

    public function getTotalAttribute() {
        return $this->CardAmount + $this->CashAmount + $this->ChequeAmount + $this->MpesaAmount;
    }

    public function getModesAttribute() {
        $text = [];
        if (!empty($this->CashAmount))
            $text[] = "Cash - " . $this->CashAmount;
        if (!empty($this->MpesaAmount))
            $text[] = 'MPESA - ' . $this->MpesaAmount;
        if (!empty($this->CardAmount))
            $text[] = $this->CardType . ' - ' . $this->CardAmount;
        if (!empty($this->ChequeAmount))
            $text[] = 'Cheque - ' . $this->ChequeAmount;
        if (!empty($this->InsuranceAmount))
            $text[] = 'Insurance - ' . $this->InsuranceAmount;
        return $text;
    }

}
