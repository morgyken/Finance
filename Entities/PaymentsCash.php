<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsCash
 *
 * @property integer $id
 * @property integer $payment
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCash whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCash wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCash whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCash whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentsCash extends Model {

    protected $guarded = [];
    public $table = 'finance_payments_cash';

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

    public function _payment() {
        return $this->hasOne(EvaluationPayments::class, 'payment');
    }

}
