<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\InsuranceInvoicePayment
 *
 * @property integer $id
 * @property integer $insurance_invoice
 * @property integer $user
 * @property float $amount
 * @property integer $batch
 * @property string $mode
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\InsuranceInvoice $invoice
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereInsuranceInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\InsuranceInvoicePayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InsuranceInvoicePayment extends Model {

    protected $table = 'finance_insurance_invoice_payments';
    protected $fillable = ['insurance_invoice', 'user', 'amount', 'mode'];

    public function invoice() {
        return $this->belongsTo(InsuranceInvoice::class, 'insurance_invoice');
    }

}
