<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\PaymentsMpesa
 *
 * @property int $id
 * @property int $payment
 * @property string|null $reference
 * @property string|null $number
 * @property string|null $paybil
 * @property string|null $account
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\EvaluationPayments $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa wherePaybil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentsMpesa extends Model {

    protected $fillable = [
        'reference', 'amount', 'payment'
    ];

    public $table = 'finance_payments_mpesa';

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

}
