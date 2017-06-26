<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;

class PatientInvoice extends Model {

    protected $fillable = [];
    public $table = 'finance_patient_invoices';

    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    public function details() {
        return $this->hasMany(PatientInvoiceDetails::class, 'invoice_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTotalAttribute() {
        $amount = $this->details->sum('amount');
        return $amount;
    }

}
