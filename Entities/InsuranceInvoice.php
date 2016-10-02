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
 * @property-read \Ignite\Finance\Entities\PatientPayments $payments
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
