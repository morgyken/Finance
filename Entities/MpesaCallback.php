<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\MpesaCallback
 *
 * @property int $id
 * @property string $msisdn
 * @property float $amount
 * @property string $mpesa_trx_date
 * @property string $mpesa_trx_id
 * @property string $trx_status
 * @property string $return_code
 * @property string $description
 * @property string $merchant_transaction_id
 * @property int $added
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereMerchantTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereMpesaTrxDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereMpesaTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereMsisdn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereReturnCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereTrxStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\MpesaCallback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MpesaCallback extends Model
{
    protected $table = 'finance_mpesa_callbacks';
    protected $guarded = [];
}
