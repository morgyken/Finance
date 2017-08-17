<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Transactions
 *
 * @property int $id
 * @property int $user
 * @property string $gateway
 * @property string $account
 * @property string|null $gateway_ref
 * @property float $amount
 * @property int $reference
 * @property string $transaction
 * @property string|null $extra
 * @property string $timestamp
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereGatewayRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Transactions whereUser($value)
 * @mixin \Eloquent
 */
class Transactions extends Model
{
    protected $table = 'finance_mpesa_transactions';
    protected $guarded = [];
}
