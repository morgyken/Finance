<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class Banking extends Model {

    protected $fillable = [];
    public $table = 'finance_banking';

    public function banks() {
        return $this->belongsTo(Bank::class, 'bank', 'id');
    }

    public function accounts() {
        return $this->belongsTo(BankAccount::class, 'account', 'id');
    }

}
