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
 * Ignite\Finance\Entities\ChangeInsurance
 *
 * @property int $id
 * @property int $visit_id
 * @property int $prescription_id
 * @property int $procedure_id
 * @property string $mode
 * @property int|null $scheme_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\ChangeInsurance whereVisitId($value)
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


