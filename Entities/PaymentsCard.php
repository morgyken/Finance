<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsCard
 *
 * @property integer $id
 * @property integer $payment
 * @property string $type
 * @property string $name
 * @property string $number
 * @property string $expiry
 * @property string $security
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereExpiry($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereSecurity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentsCard extends Model {

    protected $guarded = [];
    public $table = 'finance_payments_card';

}
