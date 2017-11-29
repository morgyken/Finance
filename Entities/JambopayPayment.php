<?php

namespace Ignite\Finance\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\JambopayPayment
 *
 * @property int $id
 * @property int|null $payment_id
 * @property int|null $patient_id
 * @property string $Code
 * @property string $RevenueStreamID
 * @property string $BillNumber
 * @property string|null $CustomerNames
 * @property string $PhoneNumber
 * @property int $PaymentStatus
 * @property string|null $PaymentStatusName
 * @property float $Amount
 * @property string|null $Narration
 * @property string|null $selected_items
 * @property int $processed
 * @property int $complete
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Reception\Entities\Patients|null $patient
 * @property-read \Ignite\Finance\Entities\EvaluationPayments|null $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereCustomerNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereNarration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment wherePaymentStatusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereRevenueStreamID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereSelectedItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\JambopayPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JambopayPayment extends Model
{
    protected $guarded = [];
    protected $table = 'finance_jambo_pay_payments';

    public function payments()
    {
        return $this->belongsTo(EvaluationPayments::class, 'payment_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }
}
