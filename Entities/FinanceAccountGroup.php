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
 * Ignite\Finance\Entities\FinanceAccountGroup
 *
 * @property-read \Ignite\Finance\Entities\FinanceAccountType $types
 * @mixin \Eloquent
 */
class FinanceAccountGroup extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_account_groups';

    public function types() {
        return $this->belongsTo(FinanceAccountType::class, 'type');
    }

}
