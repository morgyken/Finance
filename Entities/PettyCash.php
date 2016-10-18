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
 * Ignite\Finance\Entities\PettyCash
 *
 * @mixin \Eloquent
 */
class PettyCash extends Model {

    protected $fillable = ['amount'];
    public $table = 'finance_petty_cash';

    //
}
