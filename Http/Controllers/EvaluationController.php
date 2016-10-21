<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Http\Requests\PaymentsRequest;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;

class EvaluationController extends AdminBaseController {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * EvaluationController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
    }

    public function payment_details($id) {
        $this->data['payment'] = EvaluationPayments::find($id);
        return view('finance::evaluation.details', ['data' => $this->data]);
    }

    public function pay_save(PaymentsRequest $request) {
        $id = $this->evaluationRepository->record_payment();
        return redirect()->route('finance.evaluation.payment_details', $id);
    }

    public function pay($patient = null) {
        if (!empty($patient)) {
            $this->data['patient'] = Patients::find($patient);
            return view('finance::evaluation.pay', ['data' => $this->data]);
        }
        $this->data['patients'] = get_patients_with_bills();
        return view('finance::evaluation.payment_list', ['data' => $this->data]);
    }

    public function accounts() {
        $this->data['patients'] = Patients::all();
        return view('finance::evaluation.patient_list', ['data' => $this->data]);
    }

    public function individual_account($patient) {
        $this->data['payments'] = EvaluationPayments::wherePatient($patient)->get();
        $this->data['patient'] = Patients::find($patient);
        return view('finance::evaluation.account', ['data' => $this->data]);
    }

    /*
      public function workbench($view = null) {
      $this->data['insurance'] = $this->data['cash'] = collect();
      if (!empty($view)) {
      switch ($view) {
      case 'insurance':
      $this->data['insurance'] = \Dervis\Modules\Finance\Entities\InsuranceInvoice::all();
      break;
      case 'cash':
      $this->data['cash'] = \Dervis\Modules\Finance\Entities\PatientPayments::all();
      break;
      }
      }
      return view('finance::workbench',['data'=>$this->data]);
      }

      public function insurance() {
      \Dervis\Helpers\FinancialFunctions::updateInvoice();
      $this->data['invoice'] = \Dervis\Modules\Finance\Entities\InsuranceInvoice::all();
      return view('finance::insurance',['data'=>$this->data]);
      }
     */

    public function insurance() {
        $this->data['all'] = Visit::wherePaymentMode('insurance');
        return view('finance::evaluation.workbench', ['data' => $this->data]);
    }

    public function summary() {
        $this->data['all'] = EvaluationPayments::all();
        return view('finance::evaluation.summary', ['data' => $this->data]);
    }

    public function cash_bills() {
        $this->data['cash'] = EvaluationPayments::all();
        return view('finance::evaluation.cash_bills', ['data' => $this->data]);
    }

}
