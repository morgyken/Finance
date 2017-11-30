<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;


class SplitInsuranceItems extends Model
{
    protected $guarded = [];
    protected $table = 'finance_split_insurance_items';

    public function prescriptions()
    {
        return $this->belongsTo(Prescriptions::class, 'prescription_id');
    }

    public function investigations()
    {
        return $this->belongsTo(Investigations::class, 'investigation_id');
    }
}
