<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class PatientTransaction extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected  $table = 'finance_patient_transactions';
}
