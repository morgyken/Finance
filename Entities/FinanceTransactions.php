<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceTransactions
 *
 * @property integer $id
 * @property integer $account
 * @property string $type
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceTransactions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceTransactions whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceTransactions whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceTransactions whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceTransactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceTransactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceTransactions extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_transactions';

}
