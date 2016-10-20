<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

use Dervis\Modules\Finance\Entities\FinanceAccountGroup;
use Dervis\Modules\Finance\Entities\FinanceAccountType;

if (!function_exists('get_account_types')) {

    /**
     * Get GL Account types
     * @return \Illuminate\Support\Collection
     */
    function get_account_types() {
        return FinanceAccountType::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_account_groups')) {

    /**
     * Get account groups
     * @return \Illuminate\Support\Collection
     */
    function get_account_groups() {
        return FinanceAccountGroup::all()->pluck('name', 'id');
    }

}