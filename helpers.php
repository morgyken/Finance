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

use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\FinanceAccountGroup;
use Ignite\Finance\Entities\FinanceAccountType;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Builder;

/**
 * Format phone number
 * @param string $number
 * @param bool $strip_plus
 * @return string
 */
function formatPhoneNumber($number, $strip_plus = false)
{
    $number = preg_replace('/\s+/', '', $number);
    /**
     * Replace with nice phone number
     * @param $needle
     * @param $replacement
     */
    $replace = function ($needle, $replacement) use (&$number) {
        if (starts_with($number, $needle)) {
            $pos = strpos($number, $needle);
            $length = strlen($needle);
            $number = substr_replace($number, $replacement, $pos, $length);
        }
    };
    $replace('2547', '+2547');
    $replace('07', '+2547');
    if ($strip_plus) {
        $replace('+254', '254');
    }
    return $number;
}

if (!function_exists('get_account_types')) {

    /**
     * Get GL Account types
     * @return \Illuminate\Support\Collection
     */
    function get_account_types()
    {
        return FinanceAccountType::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_account_groups')) {

    /**
     * Get account groups
     * @return \Illuminate\Support\Collection
     */
    function get_account_groups()
    {
        return FinanceAccountGroup::all()->pluck('name', 'id');
    }
}

if (!function_exists('payment_modes')) {

    /**
     * @param EvaluationPayments $payment
     * @return string
     */
    function payment_modes(EvaluationPayments $payment)
    {
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

    function get_patient_invoice_payment_status($invoice, $current_amount)
    {
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
    function get_payment_balance($payment, $invoice = null)
    {
        $balance = $payment->amount;
        $consumed = 0;
        foreach ($payment->details as $item) {
            if ($item->patient_invoice !== $invoice) {
                $consumed += $item->patient_invoices->total;
                $balance -= $consumed;
            }
        }
        return $balance;
    }

}

if (!function_exists('get_patient_invoice_paid_amount')) {

    function get_patient_invoice_paid_amount($id)
    {
        return Ignite\Finance\Entities\EvaluationPayments::whereHas('details', function ($query) use ($id) {
            $query->wherePatient_invoice($id);
        })
            ->sum('amount');
    }

}


if (!function_exists('total_patient_payments')) {

    function total_patient_payments($patient)
    {
        $sum = 0;
        $payments = EvaluationPayments::wherePatient($patient)->get();
        foreach ($payments as $payment) {
            $sum += $payment->total;
        }
        return $sum;
    }

}


if (!function_exists('overall_patient_service_cost')) {

    function overall_patient_service_cost($patient)
    {
        $amount = 0;

        $visits = Visit::wherePatient($patient)
            ->wherePayment_mode('cash')
            ->get();

        foreach ($visits as $visit) {
            $amount += $visit->total_bill;
        }
        return $amount;
    }

}


if (!function_exists('get_patient_unpaid')) {

    function get_patient_unpaid($patient)
    {
        $amount = 0;
        $visits = Visit::wherePatient($patient, function ($query) {
            $query->wherePayment_mode('cash');
        })->get();
        foreach ($visits as $visit) {
            $amount += $visit->unpaid_amount;
        }
        return $amount;
    }

}

if (!function_exists('get_patient_balance')) {

    function get_patient_balance($patient)
    {
        $paid = total_patient_payments($patient);
        $cost = overall_patient_service_cost($patient);
        $balance = $paid - $cost;
        return $balance;
    }

}


if (!function_exists('get_patient_invoice_pending_amount')) {
    function get_patient_invoice_pending_amount($id)
    {
        $invoice = \Ignite\Finance\Entities\PatientInvoice::find($id);
        $amount = $invoice->total;
        $paid = get_patient_invoice_paid_amount($id);
        $bal = $amount - $paid;
        return $bal;
    }
}

if (!function_exists('get_logo')) {

    function get_logo()
    {
        $this_clinic = \Session::get('clinic');
        $practice = \Ignite\Settings\Entities\Practice::findOrNew(1);
        $clinic = \Ignite\Settings\Entities\Clinics::findOrNew($this_clinic);
        if (!empty($clinic->logo)) {
            $logo = $clinic->logo;
        } else {
            $logo = $practice->logo;
        }
        return $logo;
    }

}

if (!function_exists('get_logo_image')) {

    function get_logo_image()
    {
        $this_clinic = \Session::get('clinic');
        $practice = \Ignite\Settings\Entities\Practice::findOrNew(1);
        $clinic = \Ignite\Settings\Entities\Clinics::findOrNew($this_clinic);
        if (!empty($clinic->logo)) {
            $logo = $clinic->logo;
        } else {
            $logo = $practice->logo;
        }

        return substr($logo, strpos($logo, "public/") + 7);
    }

}


if (!function_exists('get_clinic')) {

    function get_clinic()
    {
        $this_clinic = \Session::get('clinic');
        $clinic = \Ignite\Settings\Entities\Clinics::findOrNew($this_clinic);
        return $clinic;
    }

}

if (!function_exists('get_patient_balance_real')) {

    function get_patient_balance_real($patient_id)
    {
        return EvaluationPayments::wherePatient($patient_id)->whereDeposit(true)->sum('amount');
//        $account = \Ignite\Finance\Entities\PatientAccount::find($patient_id);
//        if ($account) {
//            return $account->balance;
//        }
//        return 0;
    }
}
if (!function_exists('pesa')) {
    /**
     * @param int|null $amount
     * @param int|null $subscriberNumber
     * @param int|null $referenceId
     * @return \Illuminate\Foundation\Application|mixed|pesa
     */
    function pesa($amount = null, $subscriberNumber = null, $referenceId = null)
    {
        $cashier = app('pesa');

        if (func_num_args() == 0) {
            return $cashier;
        }

        if (func_num_args() == 1) {
            return $cashier->request($amount);
        }

        if (func_num_args() == 2) {
            return $cashier->request($amount)->from($subscriberNumber);
        }

        return $cashier->request($amount)->from($subscriberNumber)->usingReferenceId($referenceId);
    }
}
if (!function_exists('transferred2cash')) {
    /**
     * @param $item_id
     * @param bool $drug
     * @return bool
     */
    function transferred2cash($item_id, $drug = false)
    {
        $finder = $drug ? 'prescription_id' : 'procedure_id';
        $count = \Ignite\Finance\Entities\ChangeInsurance::where($finder, $item_id)->count();
        return (bool)$count;
    }
}

if (!function_exists('get_clinic')) {

    function get_clinic()
    {
        $this_clinic = \Session::get('clinic');
        $clinic = \Ignite\Settings\Entities\Clinics::findOrNew($this_clinic);
        return $clinic;
    }
}
function get_billing_status($status)
{
    switch ($status) {
        case '0':
            return '<span  class="label label-default">
                        <small>
                            Billed
                        </small>
                    </span>';
        case '1':
            return '<span  class="label label-info">
                        <small>
                            Dispatched
                        </small>
                    </span>';
        case '2':
            return '<span  class="label label-primary">
                        <small>
                            Partially Paid
                        </small>
                    </span>';
        case '3':
            return '<span  class="label label-success">
                        <small>
                            Fully Paid
                        </small>
                    </span>';
        case '4':
            return ' <span  class="label label-warning">
                        <small>
                            Overpaid
                        </small>
                    </span>';
        default:
            return '<span  class="label label-danger">
                        <small>Cancelled</small>
                        </span>';
    }
}

function get_unpaid_amount(Visit $visit)
{
    $amount = 0;
    foreach ($visit->investigations as $item) {
        if (!($item->is_paid || $item->invoiced))
            $amount += $item->amount;
    }
    foreach ($visit->prescriptions as $item) {
        if (!$item->is_paid) {
            $amount += $item->priced_amount;
        }
    }
    return $amount;
}

if (!function_exists('patient_has_pharmacy_bill')) {
    function patient_has_pharmacy_bill(Visit $visit)
    {
        return Visit::whereId($visit->id)->whereHas('prescriptions.payment', function (Builder $query) {
            $query->whereComplete(false);
        })->count();
    }
}