<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Http\Requests\PaymentsRequest;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

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

    public function insurance() {
        $this->data['all'] = Visit::wherePaymentMode('insurance')->get();

        $this->data['pending'] = Visit::wherePaymentMode('insurance')
                ->whereNull('status')
                ->get();

        $this->data['billed'] = Visit::wherePaymentMode('insurance')
                ->whereStatus('billed')
                ->get();

        $this->data['canceled'] = Visit::wherePaymentMode('insurance')
                        ->whereStatus('canceled')->get();

        $this->data['dispatched'] = Visit::wherePaymentMode('insurance')
                ->whereStatus('dispatched')
                ->get();

        $this->data['unpaid'] = Visit::wherePaymentMode('insurance')
                ->where('status', '==', 'dispatched')
                ->get();

        $this->data['paid'] = Visit::wherePaymentMode('insurance')
                ->whereStatus('paid')
                ->get();

        return view('finance::evaluation.workbench', ['data' => $this->data]);
    }

    public function bill(Request $request) {
        if ($this->evaluationRepository->bill_visit($request)) {
            flash('Bill placed, thank you');
            return back();
        } else {
            flash('Bill could not be placed, thank you');
            return back();
        }
    }

    public function cancelBill(Request $request) {
        if ($this->evaluationRepository->cancel_visit_bill($request)) {
            flash('Bill cancelled, thank you');
            return back();
        } else {
            flash('Bill could not be cancelled, thank you');
            return back();
        }
    }

    public function dispatchBill(Request $request) {
        if ($this->evaluationRepository->dispatchBills($request)) {
            flash('Bills dispatched, thank you');
            return back();
        } else {
            flash('Bills could not be dispatched, please try again later');
            return back();
        }
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
