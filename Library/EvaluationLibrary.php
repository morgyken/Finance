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
use Ignite\Finance\Entities\Dispatch;

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
            $payment = new EvaluationPayments;
            $payment->patient = $this->request->patient;
            $payment->receipt = generate_receipt_no();
            $payment->user = $this->user;
            $payment->save();
            $this->payment_methods($payment);
            $this->payment_details($payment);
            $this->pay_id = $payment->id;
        });
        return $this->pay_id;
    }

    private function payment_details(EvaluationPayments $payment) {
        $__investigations = $this->__get_selected_stack();
        foreach ($__investigations as $item) {
            $investigation = Investigations::findOrFail($item);
            $detail = new EvaluationPaymentsDetails;
            $detail->price = $investigation->price;
            $detail->investigation = $item;
            $detail->payment = $payment->id;
            $detail->cost = $investigation->procedures->price;
            $detail->save();
        }
    }

    private function payment_methods(EvaluationPayments $payment) {
        if ($this->request->has('CashAmount')) {
            PaymentsCash::create([
                'amount' => $this->input['CashAmount'],
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('MpesaAmount')) {
            PaymentsMpesa::create([
                'amount' => $this->input['MpesaAmount'],
                'reference' => strtoupper($this->input['MpesaCode']),
                'payment' => $payment->id,
            ]);
        }
        if ($this->request->has('CardAmount')) {
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
        return $this->updateVisitStatus($request->id, 'billed');
    }

    public function cancel_visit_bill(Request $request) {
        return $this->updateVisitStatus($request->id, 'canceled');
    }

    public static function dispatchBills(Request $request) {
        DB::beginTransaction();
        try {
            foreach ($request->visit as $index => $visit) {
                $v = Visit::find($visit);
                $v->status = 'dispatched';
                $v->save();

                $dispatch = new Dispatch();
                $dispatch->visit = $visit;
                $dispatch->user = \Auth::user()->id;
                $dispatch->amount = $request->amount[$index];
                $dispatch->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            flash()->warning("Select at least one bill to proceed... thank you");
        }//Catch
    }

    public function updateVisitStatus($visit_id, $new_status) {
        $visit = Visit::find($visit_id);
        $visit->status = $new_status;
        return $visit->save();
    }

}
