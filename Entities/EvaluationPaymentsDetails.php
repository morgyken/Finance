<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Illuminate\Database\Eloquent\Model;


class EvaluationPaymentsDetails extends Model
{

    protected $guarded = [];
    public $table = 'finance_evaluation_payment_details';

    public function investigations()
    {
        return $this->belongsTo(Investigations::class, 'investigation');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Prescriptions::class, 'prescription_id');
    }

    public function getItemDescAttribute()
    {
        if ($this->investigations) {
            return $this->investigations->procedures->name;
        }
        if ($this->pharmacy) {
            return $this->pharmacy->drugs->name;
        }

        return 'N/A';
    }

    public function patient_invoices()
    {
        return $this->belongsTo(PatientInvoice::class, 'patient_invoice', 'id');
    }

    public function batch()
    {
        return $this->belongsTo(EvaluationPayments::class, 'payment');
    }

    public function visits()
    {
        return $this->belongsTo(\Ignite\Evaluation\Entities\Visit::class, 'visit', 'id');
    }

}
