<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class PaymentsCash extends Model {

    protected $fillable = [
        'amount', 'payment'
    ];
    
    public $table = 'finance_payments_cash';

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

    public function _payment() {
        return $this->hasOne(EvaluationPayments::class, 'payment');
    }

}
