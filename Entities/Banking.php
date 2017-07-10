<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Banking
 *
 * @property int $id
 * @property int $bank
 * @property int $account
 * @property int $user
 * @property float $amount
 * @property string $type
 * @property string $mode
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Finance\Entities\BankAccount $accounts
 * @property-read \Ignite\Finance\Entities\Bank $banks
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Banking whereUser($value)
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
