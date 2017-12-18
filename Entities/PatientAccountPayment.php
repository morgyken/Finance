<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PatientAccountPayment
 *
 * @mixin \Eloquent
 */
class PatientAccountPayment extends Model
{
    protected $guarded = [];
    protected $table = 'finance_patient_account_payments';
}
