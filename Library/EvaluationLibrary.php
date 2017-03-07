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

namespace Ignite\Finance\Library;

use Ignite\Evaluation\Entities\Investigations;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Finance\Entities\PaymentsCard;
use Ignite\Finance\Entities\PaymentsCash;
use Ignite\Finance\Entities\PaymentsCheque;
use Ignite\Finance\Entities\PaymentsMpesa;
use Ignite\Finance\Repositories\EvaluationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Library\FinanceLibrary;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\InsuranceInvoicePayment;
use Ignite\Finance\Entities\FinanceEvaluationInsurancePayments;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\DispensingDetails;
use Ignite\Inventory\Entities\InventoryBatchProductSales;

/**
 * Description of EvaluationFinanceFunctions
 *
 * @author samuel
 */
class EvaluationLibrary implements EvaluationRepository {

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $input;

    /**
     * @var
     */
    protected $user;

    /**
     * EvaluationFinanceFunctions constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
        $this->input = $this->request->all();
        if (Auth::check()) {
            $this->user = $this->request->user()->id;
        }
        $this->prepareInput($this->input);
    }

    /**
     * Record payment
     * @return bool
     */
    public function record_payment() {
        DB::transaction(function () {
            if (isset($this->request->dispensing)) {
                foreach ($this->request->dispensing as $d) {
                    $disp = Dispensing::find($d);
                    $disp->payment_status = 1;
                    $disp->save();
                }
            }
            //dd($this->request);
            if (isset($this->request->batch)) {
                foreach ($this->request->batch as $bitch) {
                    $sale = InventoryBatchProductSales::find($bitch);
                    $sale->paid = 1;
                    $sale->save();
                }
            }

            //dd($this->request);
            if (isset($this->request->dispensing)) {
                foreach ($this->request->dispensing as $disp) {
                    $sale = DispensingDetails::find($disp);
                    $sale->status = 1;
                    $sale->save();
                }
            }

            $payment = new EvaluationPayments;
            $payment->patient = $this->request->patient;
            $payment->receipt = generate_receipt_no();
            /*
              if (isset($this->request->visit)) {
              $payment->visit = $this->request->visit;
              } */
            if (isset($this->request->sale)) {
                $payment->sale = $this->request->sale;
            }
            $payment->user = $this->user;
            $payment->save();
            $payment->amount = $this->payment_methods($payment);
            $payment->save();
            $this->payment_details($this->request, $payment);
            $this->pay_id = $payment->id;
        });
        return $this->pay_id;
    }

    private function payment_details(Request $request, $payment) {
        $__investigations = $this->__get_selected_stack();
        foreach ($__investigations as $item) {
            $visit = 'visit' . $item;
            $investigation = Investigations::find($item);
            if (isset($investigation)) {
                $detail = new EvaluationPaymentsDetails;
                $detail->price = $investigation->price;
                $detail->investigation = $item;
                $detail->visit = $request->$visit;
                $detail->payment = $payment->id;
                $detail->cost = $investigation->procedures->price;
                $detail->save();
            }
        }
    }

    /**
     * Record Insurance Payment
     * return bool
     */
    public function record_insurance_payment() {
        $batch = new FinanceEvaluationInsurancePayments;
        $batch->company = $this->request->company;
        $batch->user = \Auth::user()->id;
        $batch->amount = $this->request->ChequeAmount;
        $batch->save();

        $this->saveCheque($batch);

        foreach ($this->request->invoice as $key => $invoice) {
            $amount = 'amount' . $invoice;
            $payment = new InsuranceInvoicePayment;
            $payment->amount = $this->request->$amount;
            $payment->insurance_invoice = $invoice;
            $payment->user = $this->user;
            $payment->batch = $batch->id;
            $payment->save();
            $this->updateInvoiceStatus($invoice, $this->request->$amount);
        }
        return true;
    }

    /**
     * Update Insurance Invoice Status
     * @param type invoice_id, amount
     * @return bool
     */
    public function updateInvoiceStatus($invoice, $amount) {
        $paid = $this->getPriorInvoicePaidAmount($invoice);
        $settled = $amount + $paid;
        $inv = InsuranceInvoice::find($invoice);
        $bill = $inv->payment;
        if ($settled < $bill) {//partially paid (2)
            $inv->status = 2;
        } elseif ($settled > $bill) {//fully (3)
            $inv->status = 3;
        }/* elseif ($settled > $bill) {// overpaid (4)
          $inv->status = 4;
          } */
        $inv->save();
    }

    public function getPriorInvoicePaidAmount($invoice) {
        $payment = InsuranceInvoicePayment::where('insurance_invoice', '=', $invoice)->get(); //find(['insurance_invoice' => $invoice]);
        if (!$payment->isEmpty()) {
            $paid = 0;
            foreach ($payment as $p) {
                $paid+=$p->amount;
            }
            return $paid;
        } else {
            return 0;
        }
    }

    private function payment_methods(EvaluationPayments $payment) {
        $paid_amount = 0;
        if ($this->request->has('CashAmount')) {
            $paid_amount+=$this->input['CashAmount'];
            PaymentsCash::create([
                'amount' => $this->input['CashAmount'],
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('MpesaAmount')) {
            $paid_amount+=$this->input['MpesaAmount'];
            PaymentsMpesa::create([
                'amount' => $this->input['MpesaAmount'],
                'reference' => strtoupper($this->input['MpesaCode']),
                'payment' => $payment->id,
            ]);
        }
        if ($this->request->has('CardAmount')) {
            $paid_amount+=$this->input['CardAmount'];
            PaymentsCard::create([
                'type' => $this->input['CardType'],
                'name' => strtoupper($this->input['CardNames']),
                'number' => $this->input['CardNumber'],
                'expiry' => $this->input['CardExpiry'],
                'amount' => $this->input['CardAmount'],
                'security' => '000',
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('ChequeAmount')) {
            $paid_amount+=$this->input['ChequeAmount'];
            PaymentsCheque::create([
                'name' => strtoupper($this->input['ChequeName']),
                'date' => new \Date($this->input['ChequeDate']),
                'amount' => $this->input['ChequeAmount'],
                'bank' => $this->input['ChequeBank'],
                'bank_branch' => $this->input['ChequeBankBranch'],
                'number' => $this->input['ChequeNumber'],
                'payment' => $payment->id
            ]);
        }

        if ($this->request->has('visit')) {
            $this->update_visit_payment_status($this->input['visit'], $paid_amount);
        }

        return $paid_amount;
    }

    /*
     * Save Payment Cheque
     * @return
     * @param payment
     *
     */

    public function saveCheque($payment) {
        $cheque = new PaymentsCheque;
        $cheque->name = strtoupper($this->input['ChequeName']);
        $cheque->date = new \Date($this->input['ChequeDate']);
        $cheque->amount = $this->input['ChequeAmount'];
        $cheque->bank = $this->input['ChequeBank'];
        $cheque->bank_branch = $this->input['ChequeBankBranch'];
        $cheque->number = $this->input['ChequeNumber'];
        $cheque->insurance_payment = $payment->id;
        $cheque->save();
    }

    public static function update_visit_payment_status($id, $amount) {
        $visit = Visit::find($id);

        $bill = $visit->unpaid_amount;

        $payment = EvaluationPayments::where('visit', '=', $id)->get();
        $pre_paid = 0;

        foreach ($payment as $item) {
            $pre_paid+=$item->amount;
        }
        $total_paid = $pre_paid + $amount;
        if ($bill <= $total_paid) {
            $visit->status = 'paid';
        } elseif ($bill >= $total_paid) {
            $visit->status = 'partially paid';
        }
        return $visit->update();
    }

    private function prepareInput(&$input) {
        unset($input['_token']);
        foreach ($input as $key => $value) {
            if (empty($value)) {
                unset($input[$key]);
            }
        }
        if (!empty($input['id'])) {
            $this->id = $input['id'];
            unset($input['id']);
        }
    }

    /**
     * Build an index of items dynamically
     * @return array
     */
    private function __get_selected_stack() {
        $stack = [];
        foreach ($this->input as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
            }
        }
        return $stack;
    }

    public function bill_visit(Request $request) {
        $this->updateVisitStatus($request->id, 'billed');
        $visit = Visit::find($request->id);
        $visit->status = 'billed';
        $visit->save();
        $this->createInsuranceInvoice($visit->id, $visit->unpaid_amount);
        return 'billed';
    }

    public function bill_visit_many(Request $request) {
        foreach ($request->visit as $i => $visit) {
            $this->updateVisitStatus($request->visit[$i], 'billed');
            $visit = Visit::find($request->visit[$i]);
            $this->createInsuranceInvoice($request->visit[$i], $visit->unpaid_amount);
        }
        return TRUE;
    }

    public function cancel_visit_bill(Request $request) {
        $inv = InsuranceInvoice::find($request->id);
        $inv->status = 5;
        return $inv->update();
    }

    public function undoBillCancel(Request $request) {
        $inv = InsuranceInvoice::find($request->id);
        $inv->status = 0;
        return $inv->update();
    }

    public static function dispatchBills(Request $request) {
        FinanceLibrary::dispatchBills($request);
        return TRUE;
    }

    public function updateVisitStatus($visit_id, $new_status) {
        $visit = Visit::find($visit_id);
        $visit->status = $new_status;
        return $visit->save();
    }

    public function createInsuranceInvoice($visit, $amount) {
        $inv = new InsuranceInvoice;
        $inv->invoice_no = 'INV-' . $visit . '-' . date('dmyHis');
        $inv->visit = $visit;
        $inv->payment = $amount;
        $inv->save();
    }

}
