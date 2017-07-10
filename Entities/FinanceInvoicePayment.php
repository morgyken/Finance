<?php

namespace Ignite\Finance\Entities;

use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceInvoicePayment
 *
 * @property int $id
 * @property int|null $account
 * @property int|null $user
 * @property string $mode
 * @property float $amount
 * @property int|null $grn
 * @property int|null $invoice
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\BankAccount|null $accounts
 * @property-read \Ignite\Inventory\Entities\InventoryBatch|null $grns
 * @property-read \Ignite\Inventory\Entities\InventoryInvoice|null $invoices
 * @property-read \Ignite\Users\Entities\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereGrn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceInvoicePayment whereUser($value)
 * @mixin \Eloquent
 */
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
