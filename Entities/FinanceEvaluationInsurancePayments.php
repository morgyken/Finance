<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


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
