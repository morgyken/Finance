<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class PettyCashUpdates extends Model {

    protected $fillable = [];
    public $table = 'finance_petty_cash_updates';

    public function users() {
        return $this->belongsTo(\Dervis\Modules\Core\Entities\User::class, 'user', 'id');
    }

}
