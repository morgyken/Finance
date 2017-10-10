<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\PrescriptionPayment;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Evaluation\Entities\Visit;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoice
 *
 * @property int $id
 * @property string $invoice_no
 * @property int|null $visit
 * @property int|null $receipt
 * @property int|null $payment
 * @property string|null $invoice_date
 * @property string|null $dispatch
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $paid
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Investigations[] $investigations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\InsuranceInvoicePayment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\PrescriptionPayment[] $prescriptions
 * @property-read \Ignite\Inventory\Entities\InventoryBatchProductSales|null $sales
 * @property-read \Ignite\Evaluation\Entities\Visit|null $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereDispatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoice whereVisit($value)
 * @mixin \Eloquent
 */
class InsuranceInvoice extends Model
{

    protected $fillable = [];
    public $table = 'finance_insurance_invoices';

    public function sales()
    {
        return $this->belongsTo(InventoryBatchProductSales::class, 'receipt', 'id');
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit', 'id');
    }

    public function payments()
    {
        return $this->hasMany(InsuranceInvoicePayment::class, 'insurance_invoice');
    }

    public function getPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function investigations()
    {
        return $this->hasMany(Investigations::class, 'invoiced');
    }

    public function prescriptions()
    {
        return $this->hasMany(PrescriptionPayment::class, 'invoiced');
    }
}
