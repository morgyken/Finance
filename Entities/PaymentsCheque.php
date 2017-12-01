<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class PaymentsCheque extends Model {

    protected $fillable = [
        'name', 'date', 'amount', 'bank', 'bank_branch', 'number', 'deposit', 'insurance_payment', 'payment'
    ];

    public $table = 'finance_payments_cheque';

    public function insurance_payments() {
        return $this->belongsTo(FinanceEvaluationInsurancePayments::class, 'insurance_payment');
    }

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

}
