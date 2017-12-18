<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\InsuranceInvoicePayment
 *
 * @property int $id
 * @property int $insurance_invoice
 * @property int $user
 * @property float $amount
 * @property int|null $batch
 * @property string|null $mode
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\InsuranceInvoice $invoice
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereInsuranceInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereUser($value)
 * @mixin \Eloquent
 */
class InsuranceInvoicePayment extends Model {

    protected $table = 'finance_insurance_invoice_payments';
    protected $fillable = ['insurance_invoice', 'user', 'amount', 'mode'];

    public function invoice() {
        return $this->belongsTo(InsuranceInvoice::class, 'insurance_invoice');
    }

    public function users() {
        return $this->belongsTo(\Ignite\Users\Entities\User::class, 'user');
    }

}
