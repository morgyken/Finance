<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class PaymentsMpesa extends Model {

    protected $fillable = [
        'reference', 'amount', 'payment'
    ];

    public $table = 'finance_payments_mpesa';

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

}
