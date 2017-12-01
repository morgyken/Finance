<?php
namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Reception\Entities\PatientInsurance;
use Illuminate\Database\Eloquent\Model;


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


