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

if (!function_exists('get_patient_invoice_payment_status')) {

    function get_patient_invoice_payment_status($invoice, $current_amount) {
        $amount_paid = get_patient_invoice_paid_amount($invoice->id);
        $whole_amount = $amount_paid + $current_amount;
        if ($current_amount < 0 && $amount_paid < 0) {
            $status = 'unpaid';
        } elseif ($whole_amount >= $invoice->total) {
            $status = 'paid';
        } elseif ($whole_amount > 0 && $whole_amount < $invoice->total) {
            $status = 'part_paid';
        }
        return $status;
    }

}

if (!function_exists('get_payment_balance')) {

    function get_payment_balance($payment, $invoice = null) {
        $balance = $payment->amount;
        $consumed = 0;
        foreach ($payment->details as $item) {
            if ($item->patient_invoice !== $invoice) {
                $consumed+=$item->patient_invoices->total;
                $balance-=$consumed;
            }
        }
        return $balance;
    }

}

if (!function_exists('get_patient_invoice_paid_amount')) {

    function get_patient_invoice_paid_amount($id) {
        return Ignite\Finance\Entities\EvaluationPayments::whereHas('details', function($query)use($id) {
                            $query->wherePatient_invoice($id);
                        })
                        ->sum('amount');
    }

}

if (!function_exists('get_patient_invoice_pending_amount')) {

    function get_patient_invoice_pending_amount($id) {
        $invoice = \Ignite\Finance\Entities\PatientInvoice::find($id);
        $amount = $invoice->total;
        return $amount - get_patient_invoice_paid_amount($id);
    }

}