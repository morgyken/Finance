<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Investigations;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\EvaluationPaymentsDetails
 *
 * @property integer $id
 * @property integer $payment
 * @property integer $investigation
 * @property float $cost
 * @property float $price
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Investigations $investigations
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereInvestigation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPaymentsDetails extends Model {

    protected $guarded = [];
    public $table = 'finance_evaluation_payment_details';

    public function investigations() {
        return $this->belongsTo(Investigations::class, 'investigation', 'id');
    }

    public function batch() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

    public function visits() {
        return $this->belongsTo(\Ignite\Evaluation\Entities\Visit::class, 'visit', 'id');
    }

}
