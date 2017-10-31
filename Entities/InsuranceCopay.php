<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceCopay
 *
 * @property int $id
 * @property int $visit_id
 * @property int $scheme_id
 * @property int $company_id
 * @property int $procedure_id
 * @property int $patient_id
 * @property float $amount
 * @property int $paid
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Evaluation\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceCopay whereVisitId($value)
 * @mixin \Eloquent
 */
class InsuranceCopay extends Model
{
    protected $table = 'finance_insurance_copay';
    protected $guarded = [];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }
}
