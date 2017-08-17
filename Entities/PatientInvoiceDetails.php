<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PatientInvoiceDetails
 *
 * @property int $id
 * @property int $invoice_id
 * @property int|null $investigation_id
 * @property int|null $dispensing_id
 * @property int $item_id
 * @property string $item_name
 * @property string|null $item_type
 * @property float $amount
 * @property string|null $service_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereDispensingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereInvestigationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereItemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereServiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientInvoiceDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientInvoiceDetails extends Model {

    protected $fillable = [];
    public $table = 'finance_patient_invoice_details';

}
