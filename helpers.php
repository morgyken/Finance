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


if (!function_exists('total_patient_payments')) {

    function total_patient_payments($patient) {
        $sum = 0;
       $payments = EvaluationPayments::wherePatient($patient)->get();
        foreach ($payments as $payment){
            $sum+=$payment->total;
        }
        return $sum;
    }

}

if (!function_exists('overall_patient_service_cost')) {

    function overall_patient_service_cost($patient) {
        $amount = 0;

        $visits = \Ignite\Evaluation\Entities\Visit::wherePatient($patient)
            ->wherePayment_mode('cash')
            ->get();

        foreach ($visits as $visit){
            $amount+=$visit->total_bill;
        }
        return $amount;
    }

}


if (!function_exists('get_patient_unpaid')) {

    function get_patient_unpaid($patient) {
        $amount = 0;
        $visits = \Ignite\Evaluation\Entities\Visit::wherePatient($patient, function($query){
            $query->wherePayment_mode('cash');
        })->get();
        foreach ($visits as $visit){
            $amount+=$visit->unpaid_amount;
        }
        return $amount;
    }

}

if (!function_exists('get_patient_balance')) {

    function get_patient_balance($patient) {
        $paid = total_patient_payments($patient);
        $cost = overall_patient_service_cost($patient);
        $balance = $paid-$cost;
        return $balance;
    }

}


if (!function_exists('get_patient_invoice_pending_amount')) {

    function get_patient_invoice_pending_amount($id) {
        $invoice = \Ignite\Finance\Entities\PatientInvoice::find($id);
        $amount = $invoice->total;
        return $amount - get_patient_invoice_paid_amount($id);
    }

}

if (!function_exists('get_logo')) {

    function get_logo() {
        $logo = null;
        $this_clinic =\Session::get('clinic');
        $practice = \Ignite\Settings\Entities\Practice::findOrNew(1);
        $clinic = \Ignite\Settings\Entities\Clinics::findOrNew($this_clinic);
        if(!empty($clinic->logo)){
            $logo = $clinic->logo;
        }else{
            $logo = $practice->logo;
        }
        return $logo;
    }

}

if (!function_exists('get_clinic')) {

    function get_clinic() {
        $this_clinic =\Session::get('clinic');
        $clinic = \Ignite\Settings\Entities\Clinics::findOrNew($this_clinic);
        return $clinic;
    }

}