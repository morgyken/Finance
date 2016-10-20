<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\FinanceTransactions
 *
 * @property integer $id
 * @property integer $account
 * @property string $type
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceTransactions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceTransactions whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceTransactions whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceTransactions whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceTransactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceTransactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceTransactions extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_transactions';

}
