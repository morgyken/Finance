<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;


/**
 * Ignite\Finance\Entities\PatientInvoice
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $user_id
 * @property float|null $amount
 * @property string|null $description
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\PatientInvoiceDetails[] $details
 * @property-read mixed $total
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Users\Entities\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoice whereUserId($value)
 * @mixin \Eloquent
 */
class PatientInvoice extends Model {

    protected $fillable = [];
    public $table = 'finance_patient_invoices';

    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    public function details() {
        return $this->hasMany(PatientInvoiceDetails::class, 'invoice_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTotalAttribute() {
        $amount = $this->details->sum('amount');
        return $amount;
    }

}
