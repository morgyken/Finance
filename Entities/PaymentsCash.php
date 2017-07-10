<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsCash
 *
 * @property int $id
 * @property int $payment
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\EvaluationPayments $_payment
 * @property-read \Ignite\Finance\Entities\EvaluationPayments $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCash whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCash wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCash whereUpdatedAt($value)
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
