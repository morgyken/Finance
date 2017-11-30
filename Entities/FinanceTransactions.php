<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class FinanceTransactions extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_transactions';

}
