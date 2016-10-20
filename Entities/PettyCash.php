<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model {

    protected $fillable = ['amount'];
    public $table = 'finance_petty_cash';

    //
}
