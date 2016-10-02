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
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PatientAccount
 *
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @mixin \Eloquent
 */
class PatientAccount extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = config('db.patient_accounts');
    }

    public function patients() {
        return $this->belongsTo(Patients::class, 'patient', 'patient_id');
    }

}
