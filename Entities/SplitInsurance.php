<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 11/2/17
 * Time: 2:11 PM
 */
namespace Ignite\Finance\Entities;

use Ignite\Inpatient\Entities\Visit;
use Ignite\Reception\Entities\PatientInsurance;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\SplitInsurance
 *
 * @property-read \Ignite\Reception\Entities\PatientInsurance $_scheme
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\SplitInsuranceItems[] $children
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
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


