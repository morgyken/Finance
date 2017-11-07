<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;

/**
 * Ignite\Finance\Entities\SplitInsuranceItems
 *
 * @property-read \Ignite\Evaluation\Entities\Investigations $investigations
 * @property-read \Ignite\Evaluation\Entities\Prescriptions $prescriptions
 * @mixin \Eloquent
 */
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
