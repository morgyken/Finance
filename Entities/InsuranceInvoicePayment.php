<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoicePayment
 *
 * @mixin \Eloquent
 */
class InsuranceInvoicePayment extends Model {

    protected $table = 'finance_insurance_invoice_payments';
    protected $fillable = ['insurance_invoice', 'user', 'amount', 'mode'];

}
