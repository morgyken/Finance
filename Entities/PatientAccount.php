<?php

namespace Ignite\Finance\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\PatientAccount
 *
 * @property int $id
 * @property int $patient
 * @property float $balance
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientAccount whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientAccount wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientAccount extends Model
{

    protected $table = 'finance_patient_accounts';
    protected $guarded = [];

    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient', 'patient_id');
    }

    public function getLatestBalance($id)
    {
        return get_patient_balance($id);
        return PatientAccount::where("patient", $id)->latest()->first()->balance;
    }

    public static function latestBalance($id)
    {
        return PatientAccount::where("patient", $id)->latest()->first();
    }

}
