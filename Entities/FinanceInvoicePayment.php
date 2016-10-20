<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class FinanceInvoicePayment extends Model {

    protected $fillable = [];

    public function users() {
        return $this->belongsTo(\Ignite\Core\Entities\User::class, 'user', 'id');
    }

    public function grns() {
        return $this->belongsTo(\Ignite\Inventory\Entities\InventoryBatch::class, 'grn', 'id');
    }

    public function invoices() {
        return $this->belongsTo(\Ignite\Inventory\Entities\InventoryInvoice::class, 'invoice', 'id');
    }

    public function accounts() {
        return $this->belongsTo(BankAccount::class, 'account', 'id');
    }

}
