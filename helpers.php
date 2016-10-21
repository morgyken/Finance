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
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\FinanceAccountGroup;
use Ignite\Finance\Entities\FinanceAccountType;

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
if (!function_exists('payment_modes')) {

    /**
     * @param EvaluationPayments $payment
     * @return string
     */
    function payment_modes(EvaluationPayments $payment) {
        $modes = [];
        if (!empty($payment->cash)) {
            $modes[] = 'Cash';
        }
        if (!empty($payment->card)) {
            $modes[] = 'Credit Card';
        }
        if (!empty($payment->mpesa)) {
            $modes[] = 'Mpesa';
        }
        if (!empty($payment->cheque)) {
            $modes[] = 'Cheque';
        }
        return implode(' | ', $modes);
    }

}