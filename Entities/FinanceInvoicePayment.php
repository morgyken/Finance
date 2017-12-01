<?php

namespace Ignite\Finance\Entities;

use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


class FinanceInvoicePayment extends Model {

    protected $fillable = [];

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function grns() {
        return $this->belongsTo(InventoryBatch::class, 'grn', 'id');
    }

    public function invoices() {
        return $this->belongsTo(InventoryInvoice::class, 'invoice', 'id');
    }

    public function accounts() {
        return $this->belongsTo(BankAccount::class, 'account', 'id');
    }

}
