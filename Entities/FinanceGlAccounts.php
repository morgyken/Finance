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

/**
 * Ignite\Finance\Entities\FinanceGlAccounts
 *
 * @property-read \Ignite\Finance\Entities\FinanceAccountGroup $groups
 * @mixin \Eloquent
 */
class FinanceGlAccounts extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_accounts';

    public function groups() {
        return $this->belongsTo(FinanceAccountGroup::class, 'group');
    }

}
