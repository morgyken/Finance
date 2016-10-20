<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\InsuranceInvoice
 *
 * @property integer $id
 * @property string $invoice_no
 * @property integer $payment
 * @property string $invoice_date
 * @property string $dispatch
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Dervis\Modules\Finance\Entities\PatientPayments $payments
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereInvoiceNo($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereDispatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\InsuranceInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InsuranceInvoice extends Model {

    public $fillable = ['payment'];
    //public $primaryKey = 'invoice_no';
    public $incrementing = false;

    public function payments() {
        return $this->hasOne(PatientPayments::class, 'payment_id', 'payment');
    }

    public function sales() {
        return $this->belongsTo(\Dervis\Modules\Inventory\Entities\InventoryBatchProductSales::class, 'receipt', 'id');
    }

}
