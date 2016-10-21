<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\BankAccount
 *
 * @property integer $id
 * @property integer $bank
 * @property string $name
 * @property string $number
 * @property float $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\Bank $banks
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BankAccount extends Model {

    protected $fillable = [];
    public $table = 'finance_bank_accounts';

    public function banks() {
        return $this->belongsTo(Bank::class, 'bank', 'id');
    }

}
