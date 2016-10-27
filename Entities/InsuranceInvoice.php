<?php

namespace Ignite\Finance\Entities;

use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoice
 *
 * @property integer $id
 * @property string $invoice_no
 * @property integer $receipt
 * @property integer $payment
 * @property string $invoice_date
 * @property string $dispatch
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryBatchProductSales $sales
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceNo($value)
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

}
