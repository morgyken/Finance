<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceGlAccounts
 *
 * @property integer $id
 * @property integer $group
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\FinanceAccountGroup $groups
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceGlAccounts whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceGlAccounts whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceGlAccounts whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceGlAccounts whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceGlAccounts whereUpdatedAt($value)
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
