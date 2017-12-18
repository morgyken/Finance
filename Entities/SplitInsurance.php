<?php
namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Reception\Entities\PatientInsurance;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\SplitInsurance
 *
 * @property int $id
 * @property int $visit_id
 * @property int|null $scheme
 * @property int $status
 * @property int|null $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Reception\Entities\PatientInsurance|null $_scheme
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\SplitInsuranceItems[] $children
 * @property-read \Ignite\Evaluation\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereScheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\SplitInsurance whereVisitId($value)
 * @mixin \Eloquent
 */
class SplitInsurance extends Model
{
    protected $table = 'finance_split_insurances';
    protected $guarded = [];

    public function children(){
        return $this->hasMany(SplitInsuranceItems::class,'parent_id');
    }

    public function visit(){
        return $this->belongsTo(Visit::class,'visit_id');
    }

    public function _scheme(){
        return $this->belongsTo(PatientInsurance::class,'scheme');
    }

}


