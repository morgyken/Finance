<?php

namespace Ignite\Finance\Entities;

use Ignite\Settings\Entities\Insurance;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\Copay
 *
 * @property int $id
 * @property int $visit_id
 * @property int $patient_id
 * @property int $company_id
 * @property int $scheme_id
 * @property float $amount
 * @property int|null $payment_id
 * @property int|null $invoice_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Settings\Entities\Insurance $company
 * @property-read mixed $desc
 * @property-read \Ignite\Settings\Entities\Schemes $scheme
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereVisitId($value)
 * @mixin \Eloquent
 */
class Copay extends Model
{
    protected $table = 'finance_copay';
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Insurance::class, 'company_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Schemes::class, 'scheme_id');
    }

    public function getDescAttribute()
    {
        return strtoupper('COPAY ' . substr($this->company->name, 0, 4) . '-' . substr($this->scheme->name, 0, 4));
    }
}
