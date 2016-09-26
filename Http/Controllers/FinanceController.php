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

namespace Ignite\Finance\Http\Controllers;

use Ignite\Finance\Entities\PatientPayments;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

class FinanceController extends \Ignite\Core\Http\Controllers\AdminBaseController {

    public function index() {
        return view('finance::index');
    }

    public function patient_accounts() {
        $this->data['patients'] = \Ignite\Reception\Entities\Patients::all();
        return view('finance::patient_accounts')->with('data', $this->data);
    }

    public function individual_account($patient) {
        $this->data['patient'] = \Ignite\Reception\Entities\Patients::find($patient);
        $this->data['payments'] = \Ignite\Finance\Entities\PatientPayments::wherePatient($patient)->get();
        return view('finance::individual_account')->with('data', $this->data);
    }

    public function payment_details($ref) {
        $this->data['payment'] = \Ignite\Finance\Entities\PatientPayments::find($ref);
        return view('finance::payment_details')->with('data', $this->data);
    }

    public function receive_payments(Request $request, $patient = null) {
        if ($request->isMethod('post')) {
            if ($ref = \Dervis\Helpers\FinancialFunctions::receive_payments($request, $patient)) {
                \Dervis\Helpers\FinancialFunctions::updateInvoice();
                return redirect()->route('finance::payment_details', $ref);
            }
        }
        if (!empty($patient)) {
            $this->data['patient'] = \Ignite\Reception\Entities\Patients::find($patient);
            return view('finance::receive_payments')->with('data', $this->data);
        }
        $this->data['patients'] = \Ignite\Reception\Entities\Patients::whereHas('visits', function ($query) {
                    $query->whereHas('treatments', function($q2) {
                        $q2->whereIsPaid(false);
                    });
                })->get();
        return view('finance::patient_accounts')->with('data', $this->data);
    }

    public function workbench($view = null) {
        $this->data['insurance'] = $this->data['cash'] = collect();
        if (!empty($view)) {
            switch ($view) {
                case 'insurance':
                    $this->data['insurance'] = \Ignite\Finance\Entities\InsuranceInvoice::all();
                    break;
                case 'cash':
                    $this->data['cash'] = \Ignite\Finance\Entities\PatientPayments::all();
                    break;
            }
        }
        return view('finance::workbench')->with('data', $this->data);
    }

    public function insurance() {
        \Dervis\Helpers\FinancialFunctions::updateInvoice();
        $this->data['invoice'] = \Ignite\Finance\Entities\InsuranceInvoice::all();
        return view('finance::insurance')->with('data', $this->data);
    }

}
