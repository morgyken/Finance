<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoicePayment
 *
 * @mixin \Eloquent
 */
class InsuranceInvoicePayment extends Model {

    protected $fillable = ['insurance_invoice', 'user', 'amount', 'mode'];

}
