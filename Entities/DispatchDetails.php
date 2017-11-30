<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class DispatchDetails extends Model {

    protected $table = 'finance_bill_dispatch_details';

    public function dispatchs() {
        return $this->belongsTo(Dispatch::class, 'dispatch', 'id');
    }

    public function invoice() {
        return $this->belongsTo(InsuranceInvoice::class, 'insurance_invoice', 'id');
    }

}
