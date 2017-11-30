<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class PaymentsCard extends Model {

    protected $fillable = [
        'name', 'number', 'payment', 'amount', 'expiry'
    ];

    public $table = 'finance_payments_card';

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

}
