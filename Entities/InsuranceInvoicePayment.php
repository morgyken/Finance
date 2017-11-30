<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class InsuranceInvoicePayment extends Model {

    protected $table = 'finance_insurance_invoice_payments';
    protected $fillable = ['insurance_invoice', 'user', 'amount', 'mode'];

    public function invoice() {
        return $this->belongsTo(InsuranceInvoice::class, 'insurance_invoice');
    }

    public function users() {
        return $this->belongsTo(\Ignite\Users\Entities\User::class, 'user');
    }

}
