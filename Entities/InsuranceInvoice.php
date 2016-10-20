<?php

namespace Ignite\Finance\Entities;

use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoice
 *
 * @property-read \Ignite\Inventory\Entities\InventoryBatchProductSales $sales
 * @mixin \Eloquent
 */
class InsuranceInvoice extends Model
{

    public $fillable = ['payment'];
    //public $primaryKey = 'invoice_no';
    public $incrementing = false;

    /*
        public function payments() {
            return $this->hasOne(PatientPayments::class, 'payment_id', 'payment');
        }
    */
    public function sales()
    {
        return $this->belongsTo(InventoryBatchProductSales::class, 'receipt', 'id');
    }

}
