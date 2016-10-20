<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

    protected $fillable = [];
    public $table = 'finance_bank_accounts';

    public function banks() {
        return $this->belongsTo(Bank::class, 'bank', 'id');
    }

}
