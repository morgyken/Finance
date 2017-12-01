<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\PaymentsCard;
use Ignite\Finance\Entities\PaymentsCash;
use Ignite\Finance\Entities\PaymentsCheque;
use Ignite\Finance\Entities\PaymentsMpesa;
use Ignite\Finance\Entities\SplitInsurance;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

class FinanceController extends AdminBaseController
{

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * EvaluationController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository)
    {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
        reload_payments();
    }

    public function billing()
    {
        $this->data['insurance_invoices'] = InsuranceInvoice::all();
        return view('finance::billing', ['data' => $this->data]);
    }

    public function swapModes(Request $request)
    {
        if ($this->evaluationRepository->swapBill($request)) {
            flash('That was done');
            return redirect()->route('finance.evaluation.pending');
        }
        flash()->error('Could not do that!');
        return back();
    }

    public function saveSplitBill(Request $request)
    {
        if ($this->evaluationRepository->saveSplitBill($request)) {
            flash('That was done');
            return redirect()->route('finance.evaluation.pending');
        }
        flash()->error('Could not do that!');
        return back();
    }

    public function bill(Request $request)
    {
        if ($this->evaluationRepository->bill_visit($request)) {
            flash('Bill placed, thank you');
            return redirect()->route('finance.evaluation.billed');
        }
        flash()->error('Could not do that!');
        return back();
    }

    public function invoiceInfo($inv)
    {
        $this->data['invoice'] = InsuranceInvoice::find($inv);
        return view('finance::bill_details', ['data' => $this->data]);
    }

    public function list()
    {
        $this->data['patients'] = Patients::all();
        return view('finance::accounts.patient_accounts', ['data' => $this->data]);
    }

    public function deposit($id)
    {
        $this->data['patient'] = Patients::find($id);
        return view('finance::deposit', ['data' => $this->data]);
    }

    public function doneDeposit($id)
    {
        $this->data['payment'] = EvaluationPayments::find($id);
        $this->data['patient'] = Patients::find($this->data['payment']->patient);
        return view('finance::deposit_details', ['data' => $this->data]);
    }

    public function changeMode(Request $request)
    {
        if (isset($request->split)) {
            $this->data['split'] = SplitInsurance::find($request->split);
        }
        $this->data['visit'] = Visit::find($request->id);
        return view('finance::change-mod', ['data' => $this->data]);
    }

    public function splitBill($visit_id)
    {
        $this->data['visit'] = Visit::find($visit_id);
        return view('finance::split-bill', ['data' => $this->data]);
    }

    // public function saveDeposit(Request $request, $patient)
    // {
    //     \DB::beginTransaction();
    //     $payment = new EvaluationPayments;
    //     $payment->patient = $patient;
    //     $payment->receipt = generate_receipt_no();
    //     $payment->user = $request->user()->id;
    //     $payment->deposit = true;
    //     $payment->save();
    //     $payment->amount = $this->payment_methods($request, $payment);
    //     $payment->save();
    //     \DB::commit();
    //     return redirect()->route('finance.account.deposit.done', $payment->id);
    // }

    public function printThermalInvoice(Request $request)
    {
        $bill = InsuranceInvoice::find($request->id);
        $k = 10;
        $height = 600 + ($bill->investigations->count() * $k) + ($bill->prescriptions->count() * $k);
        $pdf = \PDF::loadView('finance::evaluation.print.invoice', ['bill' => $bill]);
        $customPaper = [0, 0, 300, $height];
        $pdf->setPaper($customPaper);
        return @$pdf->stream('Bill' . $request->id . '.pdf');
    }


    // private function payment_methods(Request $request, EvaluationPayments $payment)
    // {
    //     $paid_amount = 0;
    //     if ($request->has('CashAmount')) {
    //         $paid_amount += $this->input['CashAmount'];
    //         PaymentsCash::create([
    //             'amount' => $this->input['CashAmount'],
    //             'payment' => $payment->id
    //         ]);
    //     }
    //     if ($request->has('MpesaAmount')) {
    //         $paid_amount += $this->input['MpesaAmount'];
    //         $code = null;
    //         if (isset($this->input['MpesaCode'])) {
    //             $code = $this->input['MpesaCode'];
    //         }
    //         PaymentsMpesa::create([
    //             'amount' => $this->input['MpesaAmount'],
    //             'reference' => $code,
    //             'payment' => $payment->id,
    //         ]);
    //     }
    //     if ($request->has('CardAmount')) {
    //         $paid_amount += $this->input['CardAmount'];

    //         $type = null;
    //         $name = null;
    //         $number = null;
    //         $expiry = null;

    //         try {
    //             $type = $this->input['CardType'];
    //             $name = $this->input['CardNames'];
    //             $number = $this->input['CardNumber'];
    //             $expiry = $this->input['CardExpiry'];
    //         } catch (\Exception $ex) {
    //             //
    //         }


    //         PaymentsCard::create([
    //             'type' => $type,
    //             'name' => $name,
    //             'number' => $number,
    //             'expiry' => $expiry,
    //             'amount' => $this->input['CardAmount'],
    //             'security' => '000',
    //             'payment' => $payment->id
    //         ]);
    //     }
    //     if ($request->has('ChequeAmount')) {
    //         $paid_amount += $this->input['ChequeAmount'];

    //         $ChequeName = null;
    //         $ChequeDate = null;
    //         $ChequeBank = null;
    //         $ChequeBankBranch = null;
    //         $ChequeNumber = null;

    //         try {
    //             $ChequeName = $this->input['ChequeName'];
    //             $ChequeDate = $this->input['ChequeDate'];
    //             $ChequeBank = $this->input['ChequeBank'];
    //             $ChequeBankBranch = $this->input['ChequeBankBranch'];
    //             $ChequeNumber = $this->input['ChequeNumber'];
    //         } catch (\Exception $ex) {

    //         }

    //         PaymentsCheque::create([
    //             'name' => $ChequeName,
    //             'date' => $ChequeDate,
    //             'amount' => $this->input['ChequeAmount'],
    //             'bank' => $ChequeBank,
    //             'bank_branch' => $ChequeBankBranch,
    //             'number' => $ChequeNumber,
    //             'payment' => $payment->id
    //         ]);
    //     }
    //     return $paid_amount;
    // }
}
