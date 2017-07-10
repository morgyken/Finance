<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentsCheque
 *
 * @property int $id
 * @property int|null $payment
 * @property int|null $insurance_payment
 * @property string|null $name
 * @property string|null $number
 * @property string|null $date
 * @property string|null $bank
 * @property string|null $bank_branch
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\FinanceEvaluationInsurancePayments|null $insurance_payments
 * @property-read \Ignite\Finance\Entities\EvaluationPayments|null $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereBankBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereInsurancePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentsCheque whereUpdatedAt($value)
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
