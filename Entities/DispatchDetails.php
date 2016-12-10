<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\DispatchDetails
 *
 * @property integer $id
 * @property integer $insurance_invoice
 * @property integer $dispatch
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\Dispatch $dispatchs
 * @property-read \Ignite\Finance\Entities\InsuranceInvoice $invoice
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\DispatchDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\DispatchDetails whereInsuranceInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\DispatchDetails whereDispatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\DispatchDetails whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\DispatchDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\DispatchDetails whereUpdatedAt($value)
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
