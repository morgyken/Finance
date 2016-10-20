<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Banking
 *
 * @property integer $id
 * @property integer $bank
 * @property integer $account
 * @property integer $user
 * @property float $amount
 * @property string $type
 * @property string $mode
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\Bank $banks
 * @property-read \Ignite\Finance\Entities\BankAccount $accounts
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Banking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Banking extends Model {

    protected $fillable = [];
    public $table = 'finance_banking';

    public function banks() {
        return $this->belongsTo(Bank::class, 'bank');
    }

    public function accounts() {
        return $this->belongsTo(BankAccount::class, 'account');
    }

}
