<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Finance\Entities;

use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceInvoicePayment
 *
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Inventory\Entities\InventoryBatch $grns
 * @property-read \Ignite\Inventory\Entities\InventoryInvoice $invoices
 * @property-read \Ignite\Finance\Entities\BankAccount $accounts
 * @mixin \Eloquent
 */
class FinanceInvoicePayment extends Model {

    protected $fillable = [];

    public function users() {
        return $this->belongsTo(User::class, 'user', 'id');
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
