<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceEvaluationInsurancePayments
 *
 * @property integer $id
 * @property integer $company
 * @property float $amount
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Settings\Entities\Insurance $companies
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\InsuranceInvoicePayment[] $details
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceEvaluationInsurancePayments whereUpdatedAt($value)
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
