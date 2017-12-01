<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class FinanceAccountGroup extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_account_groups';

    public function types() {
        return $this->belongsTo(FinanceAccountType::class, 'type');
    }

}
