<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class Transactions extends Model
{
    protected $table = 'finance_mpesa_transactions';
    protected $guarded = [];
}
