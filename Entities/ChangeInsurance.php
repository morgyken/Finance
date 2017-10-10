<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\ChangeInsurance
 *
 * @property int $id
 * @property int $patient_id
 * @property int $prescription_id
 * @property int $procedure_id
 * @property string $mode
 * @property int|null $scheme_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereUserId($value)
 * @mixin \Eloquent
 */
class ChangeInsurance extends Model
{
    protected $table = 'finance_change_insurances';
    protected $guarded = [];
}
