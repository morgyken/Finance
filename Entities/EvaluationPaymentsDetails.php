<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Investigations;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\EvaluationPaymentsDetails
 *
 * @property int $id
 * @property int $payment
 * @property int|null $investigation
 * @property int|null $visit
 * @property int|null $patient_invoice
 * @property float|null $patient_invoice_amount
 * @property float|null $cost
 * @property float|null $price
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\EvaluationPayments $batch
 * @property-read \Ignite\Evaluation\Entities\Investigations|null $investigations
 * @property-read \Ignite\Finance\Entities\PatientInvoice|null $patient_invoices
 * @property-read \Ignite\Evaluation\Entities\Visit|null $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereInvestigation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails wherePatientInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails wherePatientInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\EvaluationPaymentsDetails whereVisit($value)
 * @mixin \Eloquent
 */
class EvaluationPaymentsDetails extends Model {

    protected $guarded = [];
    public $table = 'finance_evaluation_payment_details';

    public function investigations() {
        return $this->belongsTo(Investigations::class, 'investigation', 'id');
    }

    public function patient_invoices() {
        return $this->belongsTo(PatientInvoice::class, 'patient_invoice', 'id');
    }

    public function batch() {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

    public function visits() {
        return $this->belongsTo(\Ignite\Evaluation\Entities\Visit::class, 'visit', 'id');
    }

}
