<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceEvaluationInsurancePayments
 *
 * @property int $id
 * @property int $company
 * @property float $amount
 * @property int $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Settings\Entities\Insurance $companies
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\InsuranceInvoicePayment[] $details
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereUser($value)
 * @mixin \Eloquent
 */
class FinanceEvaluationInsurancePayments extends Model {

    protected $fillable = [];
    public $table = 'finance_evaluation_insurance_payments';

    public function companies() {
        return $this->belongsTo(\Ignite\Settings\Entities\Insurance::class, 'company');
    }

    public function details() {
        return $this->hasMany(InsuranceInvoicePayment::class, 'batch');
    }

}
