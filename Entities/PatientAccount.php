<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PatientAccount
 *
 * @property integer $id
 * @property string $reference
 * @property string $details
 * @property float $credit
 * @property float $debit
 * @property integer $patient
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereReference($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereDetails($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereDebit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PatientAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientAccount extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = config('db.patient_accounts');
    }

    public function patients() {
        return $this->belongsTo(\Ignite\Reception\Entities\Patients::class, 'patient', 'patient_id');
    }

}
