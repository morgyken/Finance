<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PaymentManifest
 *
 * @property int $id
 * @property string $type
 * @property int $visit_id
 * @property int $patient_id
 * @property int|null $company_id
 * @property int|null $scheme_id
 * @property int $has_meds
 * @property float $amount
 * @property string $date
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Evaluation\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereHasMeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PaymentManifest whereVisitId($value)
 * @mixin \Eloquent
 */
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
