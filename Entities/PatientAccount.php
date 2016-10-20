<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\PatientAccount
 *
 * @property integer $id
 * @property string $reference
 * @property string $details
 * @property float $credit
 * @property float $debit
 * @property integer $patient
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Dervis\Modules\Reception\Entities\Patients $patients
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereReference($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereDetails($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereDebit($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientAccount extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = config('db.patient_accounts');
    }

    public function patients() {
        return $this->belongsTo(\Dervis\Modules\Reception\Entities\Patients::class, 'patient', 'patient_id');
    }

}
