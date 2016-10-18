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
 * Ignite\Finance\Entities\FinanceAccountType
 *
 * @mixin \Eloquent
 */
class FinanceAccountType extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_account_types';

}
