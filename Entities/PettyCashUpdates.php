<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class PettyCashUpdates extends Model {

    protected $fillable = [];
    public $table = 'finance_petty_cash_updates';

    public function users() {
        return $this->belongsTo(\Ignite\Core\Entities\User::class, 'user', 'id');
    }

}
