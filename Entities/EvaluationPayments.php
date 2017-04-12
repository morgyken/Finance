<?php

namespace Ignite\Finance\Entities;

use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\EvaluationPayments
 *
 * @property integer $id
 * @property string $receipt
 * @property integer $patient
 * @property integer $user
 * @property float $amount
 * @property integer $visit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $total
 * @property-read mixed $modes
 * @property-read \Ignite\Finance\Entities\PaymentsCash $cash
 * @property-read \Ignite\Finance\Entities\PaymentsMpesa $mpesa
 * @property-read \Ignite\Finance\Entities\PaymentsCheque $cheque
 * @property-read \Ignite\Finance\Entities\PaymentsCard $card
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\EvaluationPaymentsDetails[] $details
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\EvaluationPayments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPayments extends Model {

    protected $fillable = [];
    public $table = 'finance_evaluation_payments';

    public function getTotalAttribute() {
        $total = 0;
        if (!empty($this->cash)) {
            $total += $this->cash->amount;
        }
        if (!empty($this->card)) {
            $total += $this->card->amount;
        }
        if (!empty($this->mpesa)) {
            $total += $this->mpesa->amount;
        }
        if (!empty($this->cheque)) {
            $total += $this->cheque->amount;
        }
        return number_format($total, 2);
    }

    public function getModesAttribute() {
        return payment_modes($this);
    }

    public function cash() {
        return $this->hasOne(PaymentsCash::class, 'payment');
    }

    public function getCashAmountAttribute() {
        $total = 0;
        if (!empty($this->cash)) {
            $total += $this->cash->amount;
        }
        return $total;
    }

    public function mpesa() {
        return $this->hasOne(PaymentsMpesa::class, 'payment');
    }

    public function cheque() {
        return $this->hasOne(PaymentsCheque::class, 'payment');
    }

    public function card() {
        return $this->hasOne(PaymentsCard::class, 'payment');
    }

    public function patients() {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function details() {
        return $this->hasMany(EvaluationPaymentsDetails::class, 'payment', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function visits() {
        return $this->belongsTo(\Ignite\Evaluation\Entities\Visit::class, 'visit');
    }

    public function sales() {
        return $this->belongsTo(\Ignite\Inventory\Entities\InventoryBatchProductSales::class, 'sale');
    }

    public function dispensing() {
        return $this->hasMany(\Ignite\Evaluation\Entities\Dispensing::class, 'dispensing', 'id');
    }

}
