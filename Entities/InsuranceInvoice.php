<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\PrescriptionPayment;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;


class InsuranceInvoice extends Model
{

    protected $fillable = [];
    public $table = 'finance_insurance_invoices';

    public function sales()
    {
        return $this->belongsTo(InventoryBatchProductSales::class, 'receipt');
    }

    public function scheme()
    {
        return $this->belongsTo(Schemes::class, 'scheme_id');
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

    public function getNiceStatusAttribute()
    {
        return get_billing_status($this->status);
    }

    public function copaid()
    {
        return $this->hasOne(Copay::class, 'invoice_id');
    }
}
