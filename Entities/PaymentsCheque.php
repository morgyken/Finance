<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsCheque
 *
 * @property integer $id
 * @property integer $payment
 * @property integer $insurance_payment
 * @property string $name
 * @property string $number
 * @property string $date
 * @property string $bank
 * @property string $bank_branch
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\FinanceEvaluationInsurancePayments $insurance_payments
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereInsurancePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereBankBranch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PaymentsCheque whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentsCheque extends Model {

    protected $guarded = [];
    public $table = 'finance_payments_cheque';

    public function insurance_payments() {
        return $this->belongsTo(FinanceEvaluationInsurancePayments::class, 'insurance_payment', 'id');
    }

    public function payments() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

}
