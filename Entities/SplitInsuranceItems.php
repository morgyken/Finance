<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;

/**
 * Ignite\Finance\Entities\SplitInsuranceItems
 *
 * @property int $id
 * @property int $parent_id
 * @property int $visit_id
 * @property int|null $prescription_id
 * @property int|null $investigation_id
 * @property string|null $mode
 * @property int|null $user_id
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Investigations|null $investigations
 * @property-read \Ignite\Evaluation\Entities\Prescriptions|null $prescriptions
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereInvestigationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsuranceItems whereVisitId($value)
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
