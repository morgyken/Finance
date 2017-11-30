<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


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
