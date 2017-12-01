<?php

namespace Ignite\Finance\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


class PettyCashUpdates extends Model {

    protected $fillable = [];
    public $table = 'finance_petty_cash_updates';

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
