<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


class Dispatch extends Model {

    protected $table = 'finance_bill_dispatches';

    public function details() {
        return $this->hasMany(DispatchDetails::class, 'dispatch');
    }

    public function company() {
        return $this->belongsTo(\Ignite\Settings\Entities\Insurance::class, 'firm', 'id');
    }

}
