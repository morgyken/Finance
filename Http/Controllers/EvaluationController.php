<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Http\Requests\PaymentsRequest;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\InsuranceInvoicePayment;
use Ignite\Finance\Entities\FinanceEvaluationInsurancePayments;
use Ignite\Finance\Entities\PaymentsCheque;
use Ignite\Finance\Entities\DispatchDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function printNormalReceipt(Request $request) {
        $this->data['payment'] = EvaluationPayments::find($request->payment);
        $pdf = \PDF::loadView('finance::evaluation.print.receipt', ['data' => $this->data]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
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
        $this->data['with_pharm'] = Patients::whereHas('visits', function ($query) {
                    $query->wherePaymentMode('cash');
                    $query->whereHas('dispensing', function ($q) {
                        $q->wherePayment_status(0);
                    });
                })->get();
        $this->data['from_pos'] = Patients::whereHas('drug_purchases', function ($query) {
                    $query->wherePaid(0);
                })->get();
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
        $this->data['bill_mode'] = 1;
        $this->data['billed'] = InsuranceInvoice::where('visit', '>', 0)
                ->get();
        return view('finance::evaluation.partials.billed', ['data' => $this->data]);
    }

    public function pendingBills() {
        $this->data['pending_mode'] = 1;
        $this->data['pending'] = Visit::wherePaymentMode('insurance')
                //->whereNull('status')
                ->orderBy('created_at', 'DESC')
                ->get();
        return view('finance::evaluation.partials.pending', ['data' => $this->data]);
    }

    public function billedBills() {
        $this->data['bill_mode'] = 1;
        $this->data['billed'] = InsuranceInvoice::where('visit', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->get();
        return view('finance::evaluation.partials.billed', ['data' => $this->data]);
    }

    public function dispatchedInvoices() {
        $this->data['dispatch_mode'] = 1;
        $this->data['dispatched'] = DispatchDetails::orderBy('created_at', 'DESC')
                ->get();
        return view('finance::evaluation.partials.dispatched', ['data' => $this->data]);
    }

    public function cancelledBills() {
        $this->data['cancel_mode'] = 1;
        $this->data['canceled'] = InsuranceInvoice::where('visit', '>', 0)
                ->whereStatus(5)
                ->orderBy('created_at', 'DESC')
                ->get();
        return view('finance::evaluation.partials.cancelled', ['data' => $this->data]);
    }

    public function companyInvoicePayment() {
        $this->data['payment_mode'] = 1;
        $this->data['billed'] = InsuranceInvoice::where('visit', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->get();
        return view('finance::evaluation.partials.payment', ['data' => $this->data]);
    }

    public function paidInvoices() {
        $this->data['paid_mode'] = 1;
        /*
          $this->data['partpaid'] = InsuranceInvoice::where('visit', '>', 0)
          ->whereStatus(2)
          ->get();
          $this->data['paid'] = InsuranceInvoice::where('visit', '>', 0)
          ->whereStatus(3)
          ->get();
          $this->data['overpaid'] = InsuranceInvoice::where('visit', '>', 0)
          ->whereStatus(4)
          ->get();
         *
         */
        $this->data['payment'] = PaymentsCheque::where('insurance_payment', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->get();
        return view('finance::evaluation.partials.paid2', ['data' => $this->data]);
    }

    public function companyStatements(Request $request) {
        $this->data['stmt_mode'] = 1;
        $this->data['payments'] = InsuranceInvoicePayment::orderBy('created_at', 'DESC')->get();

        return view('finance::evaluation.partials.firm_statement', ['data' => $this->data]);
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

    public function billMany(Request $request) {
        if ($this->evaluationRepository->bill_visit_many($request)) {
            flash('Bills placed, thank you');
            return back();
        } else {
            flash('Bills could not be placed, please try again');
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

    public function undoBillCancel(Request $request) {
        if ($this->evaluationRepository->undoBillCancel($request)) {
            flash('Bill cancellation undone successfully, thank you');
            return back();
        } else {
            flash('Bill cancellation could not be undone at this time, please try again');
            return back();
        }
    }

    public function dispatchBill(Request $request) {
        if ($this->evaluationRepository->dispatchBills($request)) {
            flash('Bill(s) dispatched, thank you');
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

    public function payInsBill(Request $request) {
        $this->data['visit'] = Visit::find($request->visit);
        return view('finance::evaluation.pay_ins_bill', ['data' => $this->data]);
    }

    public function saveInsuranceInvoicePayments(Request $request) {
        if (isset($request->company)) {
            $this->evaluationRepository->record_insurance_payment();
            return back();
        } else {
            flash()->error('Select an insurance company to continue');
            return back();
        }
    }

    public function insurancePayment(Request $request) {
        $this->data['invoices'] = InsuranceInvoice::where('visit', '>', 0)
                ->whereStatus(1)
                ->get();
        return view('finance::evaluation.insurance_payment', ['data' => $this->data]);
    }

    public function cash_bills() {
        $this->data['cash'] = EvaluationPayments::all();
        return view('finance::evaluation.cash_bills', ['data' => $this->data]);
    }

    public function printInvoice(Request $request) {
        $bill = InsuranceInvoice::find($request->id);
        $pdf = \PDF::loadView('finance::evaluation.print.invoice', ['bill' => $bill]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
    }

    public function printReceipt(Request $request) {
        $payment = FinanceEvaluationInsurancePayments::find($request->id);
        $pdf = \PDF::loadView('finance::evaluation.print.rcpt', ['payment' => $payment]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
    }

    public function billToCash(Request $request) {
        $visit = Visit::find($request->visit);
        $visit->payment_mode = 'cash';
        $visit->save();
        flash("Bill changed to cash successfully");
        return back();
    }

}
