<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsCard
 *
 * @property int $id
 * @property int $payment
 * @property string|null $type
 * @property string|null $name
 * @property string|null $number
 * @property string|null $expiry
 * @property string|null $security
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\EvaluationPayments $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentsCard extends Model {

    protected $guarded = [];
    public $table = 'finance_payments_card';

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

}
