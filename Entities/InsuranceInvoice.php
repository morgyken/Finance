<?php

namespace Ignite\Finance\Entities;

use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Evaluation\Entities\Visit;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoice
 *
 * @property integer $id
 * @property string $invoice_no
 * @property integer $visit
 * @property integer $receipt
 * @property integer $payment
 * @property string $invoice_date
 * @property string $dispatch
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryBatchProductSales $sales
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\InsuranceInvoicePayment[] $payments
 * @property-read mixed $paid
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceNo($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereDispatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InsuranceInvoice extends Model {

    protected $fillable = [];
    public $table = 'finance_insurance_invoices';

    public function sales() {
        return $this->belongsTo(InventoryBatchProductSales::class, 'receipt', 'id');
    }

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit', 'id');
    }

    public function payments() {
        return $this->hasMany(InsuranceInvoicePayment::class, 'insurance_invoice');
    }

    public function getPaidAttribute() {
        return $this->payments->sum('amount');
    }

}
