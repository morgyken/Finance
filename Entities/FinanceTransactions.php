<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\FinanceTransactions
 *
 * @property int $id
 * @property int $account
 * @property string $type
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceTransactions whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceTransactions whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceTransactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceTransactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceTransactions whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceTransactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceTransactions extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_transactions';

}
