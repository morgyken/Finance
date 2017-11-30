<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class FinanceGlAccounts extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_accounts';

    public function groups() {
        return $this->belongsTo(FinanceAccountGroup::class, 'group');
    }

}
