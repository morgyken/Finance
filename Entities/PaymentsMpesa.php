<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsMpesa
 *
 * @property integer $id
 * @property integer $payment
 * @property string $reference
 * @property string $number
 * @property string $paybil
 * @property string $account
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereReference($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa wherePaybil($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsMpesa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentsMpesa extends Model {

    protected $guarded = [];
    public $table = 'finance_payments_mpesa';

}
