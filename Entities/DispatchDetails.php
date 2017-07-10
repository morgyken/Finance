<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\DispatchDetails
 *
 * @property int $id
 * @property int $insurance_invoice
 * @property int $dispatch
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\Dispatch $dispatchs
 * @property-read \Ignite\Finance\Entities\InsuranceInvoice $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\DispatchDetails whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\DispatchDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\DispatchDetails whereDispatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\DispatchDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\DispatchDetails whereInsuranceInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\DispatchDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DispatchDetails extends Model {

    protected $table = 'finance_bill_dispatch_details';

    public function dispatchs() {
        return $this->belongsTo(Dispatch::class, 'dispatch', 'id');
    }

    public function invoice() {
        return $this->belongsTo(InsuranceInvoice::class, 'insurance_invoice', 'id');
    }

}
