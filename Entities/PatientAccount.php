<?php

namespace Ignite\Finance\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


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
