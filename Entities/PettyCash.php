<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PettyCash
 *
 * @property integer $id
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PettyCash whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PettyCash whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PettyCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\PettyCash whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PettyCash extends Model {

    protected $fillable = ['amount'];
    public $table = 'finance_petty_cash';

    //
}
