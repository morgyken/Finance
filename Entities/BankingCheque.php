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
 * Ignite\Finance\Entities\BankingCheque
 *
 * @mixin \Eloquent
 */
class BankingCheque extends Model {

    protected $fillable = [];
    protected $table = 'finance_banking_cheques';

}
