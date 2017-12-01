<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class PatientTransactionJournal extends Model
{
    protected $table = 'finance_patient_transaction_journals';
    protected $guarded = [];
}
