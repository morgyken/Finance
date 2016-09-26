<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoice
 *
 * @property integer $id
 * @property string $invoice_no
 * @property integer $payment
 * @property string $invoice_date
 * @property string $dispatch
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\PatientPayments $payments
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceNo($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereDispatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InsuranceInvoice extends Model {

    public $fillable = ['payment'];
    public $primaryKey = 'invoice_no';
    public $incrementing = false;

    public function payments() {
        return $this->hasOne(PatientPayments::class, 'payment_id', 'payment');
    }

}
