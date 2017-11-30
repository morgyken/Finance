<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


class PaymentManifest extends Model
{
    protected $table = 'finance_payment_manifests';
    protected $guarded = [];
    public $timestamps = false;

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }
}
