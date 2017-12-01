<?php

namespace Ignite\Finance\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


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
