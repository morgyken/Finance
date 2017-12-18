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

use Carbon\Carbon;
use Ignite\Evaluation\Entities\DispensingDetails;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\ChangeInsurance;
use Ignite\Finance\Entities\Copay;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Finance\Entities\FinanceEvaluationInsurancePayments;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\InsuranceInvoicePayment;
use Ignite\Finance\Entities\JambopayPayment;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Finance\Entities\PatientAccountPayment;
use Ignite\Finance\Entities\PatientInvoice;
use Ignite\Finance\Entities\PatientInvoiceDetails;
use Ignite\Finance\Entities\PatientTransaction;
use Ignite\Finance\Entities\PatientTransactionJournal;
use Ignite\Finance\Entities\PaymentManifest;
use Ignite\Finance\Entities\PaymentsCard;
use Ignite\Finance\Entities\PaymentsCash;
use Ignite\Finance\Entities\PaymentsCheque;
use Ignite\Finance\Entities\PaymentsMpesa;
use Ignite\Finance\Entities\SplitInsurance;
use Ignite\Finance\Entities\SplitInsuranceItems;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Inpatient\Entities\ChargeSheet;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Description of EvaluationFinanceFunctions
 *
 * @author samuel
 */
class EvaluationLibrary implements EvaluationRepository
{

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
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->input = $this->request->all();
        if (Auth::check()) {
            $this->user = $this->request->user()->id;
        }
        $this->prepareInput($this->input);
    }

    /**
     * @param $item
     * @return bool
     * @deprecated
     */
    private function updatePrescriptions($item)
    {
        if ($this->isDrugPayment($item)) {
            $p = Prescriptions::find(\request('item' . $item));
            $p->payment()->update(['paid' => true]);
        }
        return true;
    }

    /**
     * Record payment
     * @return bool
     */
    public function record_payment()
    {
        \DB::beginTransaction();
        if (isset($this->request->batch)) {
            foreach ($this->request->batch as $bitch) {
                $sale = InventoryBatchProductSales::find($bitch);
                $sale->paid = 1;
                $sale->save();
            }
        }
        $payment = new EvaluationPayments;
        $payment->patient = $this->request->patient;
        $payment->receipt = generate_receipt_no();

        if (isset($this->request->visit)) {
            $payment->visit = $this->request->visit;
        }
        if (isset($this->request->sale)) {
            $payment->sale = $this->request->sale;
        }
        if (isset($this->request->dispense)) {
            $dispense = json_encode($this->request->dispense);
            $payment->dispensing = json_encode(array_unique(json_decode($dispense, true)));
        }
        $payment->user = $this->user;
        $payment->save();
        $payment->amount = $this->payment_methods($payment);
        if (isset($this->request->deposit)) {
            $payment->deposit = true;
        }
        $payment->save();
        $this->payment_details($this->request, $payment);
        $this->pay_id = $payment->id;

        if (isset($this->request->deposit)) {
            $this->patient_transaction($payment, 'deposit');
        }
        \DB::commit();
        return $this->pay_id;
    }

    /**
     * Deposit Funds
     * return bool
     */
    public function patient_transaction($payment = null, $type)
    {
        $patient = $this->request->patient;
        $tr = new PatientTransaction();
        $tr->type = $type;
        $tr->patient_id = $patient;
        $tr->amount = $payment->amount;
        $tr->payment_id = $payment->id;
        $tr->save();
        $this->update_patient_balance($tr);
        return true;
    }

    /**
     * Update Patient account balance
     * return bool
     */
    public function update_patient_balance($transaction)
    {
        $account = PatientAccount::findOrNew($transaction->patient_id);
        if ($transaction->type == 'deposit') {
            $account->balance = $account->balance += $transaction->amount;
        } else {
            $account->balance = $account->balance -= $transaction->amount;
        }
        $account->patient = $transaction->patient_id;
        return $account->save();
    }

    public function create_patient_invoice()
    {
        DB::transaction(function () {
            $inv = new PatientInvoice;
            $inv->patient_id = $this->request->patient;
            $inv->user_id = $this->user;
            $inv->save();

            $__items = $this->_get_selected_stack();
            foreach ($__items as $item) {
                $id = 'item' . $item;
                $name = 'inv_name' . $item;
                $type = 'inv_type' . $item;
                $amount = 'inv_amount' . $item;
                $date = 'service_date' . $item;
                $investigation = 'investigation' . $item;
                $dispensing = 'dispensing' . $item;

                $details = new PatientInvoiceDetails;
                $details->invoice_id = $inv->id;
                $details->item_id = $this->request->$id;
                $details->investigation_id = $this->request->$investigation;
                $details->dispensing_id = $this->request->$dispensing;
                $details->item_name = $this->request->$name;
                $details->item_type = $this->request->$type;
                $details->amount = $this->request->$amount;
                $details->service_date = $this->request->$date;
                $details->save();
                try {
                    $investigation = Investigations::find($this->request->$investigation);
                    $investigation->invoiced = true;
                    $investigation->save();
                } catch (\Exception $e) {

                }

                try {
                    //Now flag them as invoiced
                    $dispensing = DispensingDetails::whereBatch($this->request->$dispensing)
                        ->whereProduct($this->request->$id)
                        ->get()
                        ->first();
                    $dispensing->invoiced = true;
                    $dispensing->save();
                } catch (\Exception $e) {
                    //pepe the frog died
                }
            }

            $this->invoice_id = $inv->id;
        });
        return $this->invoice_id;
    }

    private function payment_details(Request $request, $payment)
    {
        $items = $this->_get_selected_stack();
        foreach ($items as $item) {
            $invoice = 'invoice' . $item;
            if (isset($request->$invoice)) {
                $this->invoice_payment_details($item, $payment);
            } else {
                if ($this->isDrugPayment($item)) {
                    $this->updatePrescriptions($item);
                    $this->drug_payment_details($request, $item, $payment);
                } elseif ($this->isPaymentFor($item, 'copay')) {
                    $this->copayment($item, $payment);
                } elseif ($this->isPaymentFor($item, 'chargesheet')) {
                    $this->chargeSheetPayment($request, $item, $payment);
                } else {
                    $this->investigation_payment_details($request, $item, $payment);
                }
            }
        }
    }

    /**
     * @param string $item
     * @return bool
     * @deprecated use <code>isPaymentFor</code>
     */
    private function isDrugPayment($item): bool
    {
        return $this->isPaymentFor($item, 'pharmacy');
    }

    /**
     * Check if payment is
     * @param string $item
     * @param string $is
     * @return bool
     */
    private function isPaymentFor($item, $is): bool
    {
        if ($this->request->has('type' . $item)) {
            return (\request('type' . $item) === $is);
        }
        return false;
    }

    /**
     * @param string $item
     * @param EvaluationPayments $payment
     * @return bool
     */
    private function copayment($item, $payment)
    {
        $copay = Copay::find($item);
        $copay->payment_id = $payment->id;
        return $copay->save();
    }

    private function investigation_payment_details(Request $request, $item, $payment)
    {
        $visit = 'visits' . $item;
        $investigation = Investigations::find($item);
        $detail = new EvaluationPaymentsDetails;
        $detail->price = $investigation->price;
        $detail->investigation = $item;
        $detail->visit = $request->$visit;
        $detail->payment = $payment->id;
        $detail->cost = $investigation->procedures->price;
        $detail->save();

    }

    private function drug_payment_details(Request $request, $item, $payment)
    {
        $p = Prescriptions::find(\request('item' . $item));
        $p->payment()->update(['paid' => true]);
        $visit = 'visits' . $item;
        $detail = new EvaluationPaymentsDetails;
        $detail->price = $p->payment->total;
        $detail->prescription_id = $p->id;
        $detail->visit = $request->$visit;
        $detail->payment = $payment->id;
        $detail->cost = $p->payment->total;
        $detail->save();
    }

    private function invoice_payment_details($item, $payment)
    {
        $invoice = PatientInvoice::find($item);
        if (isset($invoice)) {
            $balance = get_payment_balance($payment, $invoice->id);
            $detail = new EvaluationPaymentsDetails;
            $detail->patient_invoice = $invoice->id;
            $detail->payment = $payment->id;
            $detail->patient_invoice_amount = $balance;
            $detail->description = 'Payment for invoice 0' . $invoice->id . ' of ' . $invoice->created_at;
            $detail->save();

            $invoice->status = get_patient_invoice_payment_status($invoice, $balance);
            $invoice->save();
        }
    }

    /**
     * Record Insurance Payment
     * return bool
     */
    public function record_insurance_payment()
    {
        \DB::beginTransaction();
        $batch = new FinanceEvaluationInsurancePayments;
        $batch->company = $this->request->company;
        $batch->user = \Auth::user()->id;
        $batch->amount = $this->request->ChequeAmount;
        $batch->save();


        $this->saveCheque($batch);
        foreach ($this->request->invoice as $key => $invoice) {
            $amount = 'amount' . $invoice;
            $this->updateInvoiceStatus($invoice, $this->request->$amount);
            $payment = new InsuranceInvoicePayment;
            $payment->amount = $this->request->$amount;
            $payment->insurance_invoice = $invoice;
            $payment->user = $this->user;
            $payment->batch = $batch->id;
            $payment->save();
        }
        \DB::commit();
        return true;
    }

    /**
     * Update Insurance Invoice Status
     * @param $invoice
     * @param $amount
     * @return bool
     */
    public function updateInvoiceStatus($invoice, $amount)
    {
        $paid = $this->getPriorInvoicePaidAmount($invoice);
        $settled = $amount + $paid;
        $inv = InsuranceInvoice::find($invoice);
        $bill = $inv->payment;
        if ($settled < $bill) {//partially paid (2)
            $inv->status = 2;
        } elseif ($settled > $bill) {//fully (3)
            $inv->status = 3;
        } elseif ($settled > $bill) {// overpaid (4)
            $inv->status = 4;
        }
        $inv->save();
    }

    /**
     * @param $invoice
     * @return mixed
     */
    public function getPriorInvoicePaidAmount($invoice)
    {
        return InsuranceInvoicePayment::where('insurance_invoice', '=', $invoice)
            ->sum('amount');
    }

    private function debitAccount($user, $amount)
    {
        $acc = PatientAccount::wherePatient($user)->first();
        $acc->balance -= $amount;
        return $acc->save();
    }

    private function payment_methods(EvaluationPayments $payment)
    {
        $paid_amount = 0;
        if ($this->request->has('cash.amount')) {
            $paid_amount += request('cash.amount');
            PaymentsCash::create([
                'amount' => \request('cash.amount'),
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('account.amount')) {
            $paid_amount += request('account.amount');
//            PatientTransactionJournal::create([
//                'amount' => \request('account.amount'),
//                'payment_id' => $payment->id,
//                'type'=>'debit'
//            ]);
            $this->debitAccount($payment->patient, \request('account.amount'));
        }
        if ($this->request->has('JPAmount')) {
            $paid_amount += request('JPAmount');
            $jp = JambopayPayment::where('BillNumber', request('JPid'))->first();
            $jp->payment_id = $payment->id;
            $jp->processed = true;
            $jp->complete = true;
            $jp->save();
        }
        if ($this->request->has('mpesa.amount')) {
            $paid_amount += request('mpesa.amount');
            $code = null;
            if ($this->request->has('mpesa.code')) {
                $code = request('mpesa.code');
            }
            PaymentsMpesa::create([
                'amount' => request('mpesa.amount'),
                'reference' => $code,
                'payment' => $payment->id,
            ]);
        }
        if ($this->request->has('card.amount')) {
            $paid_amount += request('card.amount');

            $type = null;
            $name = null;
            $number = null;
            $expiry = null;

            try {
                $type = request('card.type');
                $name = request('card.names');
                $number = request('card.number');
                $expiry = request('card.expiry');
            } catch (\Exception $ex) {
                //
            }


            PaymentsCard::create([
                'type' => $type,
                'name' => $name,
                'number' => $number,
                'expiry' => $expiry,
                'amount' => request('card.amount'),
                'security' => '000',
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('cheque.Amount')) {
            $paid_amount += request('cheque.Amount');

            $ChequeName = null;
            $ChequeDate = null;
            $ChequeBank = null;
            $ChequeBankBranch = null;
            $ChequeNumber = null;

            try {
                $ChequeName = request('cheque.name');
                $ChequeDate = request('cheque.date');
                $ChequeBank = request('cheque.bank');
                $ChequeBankBranch = request('cheque.bankBranch');
                $ChequeNumber = request('cheque.number');
            } catch (\Exception $ex) {

            }

            PaymentsCheque::create([
                'name' => $ChequeName,
                'date' => $ChequeDate,
                'amount' => request('cheque.amount'),
                'bank' => $ChequeBank,
                'bank_branch' => $ChequeBankBranch,
                'number' => $ChequeNumber,
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

    public function saveCheque($payment)
    {
        $cheque = new PaymentsCheque;
        $cheque->name = $this->input['cheque.Name'] ? strtoupper($this->input['cheque.Name']) : '';
        $cheque->date = $this->input['cheque.Date'] ? new \Date($this->input['cheque.Date']) : '';
        $cheque->amount = $this->input['cheque.Amount'];
        $cheque->bank = $this->input['cheque.Bank'] ? $this->input['cheque.Bank'] : '';
        $cheque->bank_branch = $this->input['cheque.BankBranch'] ? $this->input['cheque.BankBranch'] : '';
        $cheque->number = $this->input['cheque.Number'] ? $this->input['cheque.Number'] : '';
        $cheque->insurance_payment = $payment->id;
        $cheque->save();
    }

    public static function update_visit_payment_status($id, $amount)
    {
        $visit = Visit::find($id);

        $bill = $visit->unpaid_amount;

        $payment = EvaluationPayments::where('visit', '=', $id)->get();
        $pre_paid = 0;

        foreach ($payment as $item) {
            $pre_paid += $item->amount;
        }
        $total_paid = $pre_paid + $amount;
        if ($bill <= $total_paid) {
            $visit->status = 'paid';
        } elseif ($bill >= $total_paid) {
            $visit->status = 'partially paid';
        }
        return $visit->update();
    }

    private function prepareInput(&$input)
    {
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
     * @param null $needle
     * @return array
     */
    private function _get_selected_stack($needle = null)
    {
        $stack = [];
        $input = \request()->all();
        if (empty($needle)) {
            $needle = 'item';
        }
        foreach ($input as $key => $one) {
            if (starts_with($key, $needle)) {
                $stack[] = substr($key, strlen($needle));
            }
        }
        return $stack;
    }

    private function recordBilledItems(InsuranceInvoice $invoice)
    {
        $drugs = $this->_get_selected_stack('drugs_d');
        foreach ($drugs as $drug) {
            $p = Prescriptions::find($drug);
            $p->payment()->update(['invoiced' => $invoice->id]);
        }
        $procedures = $this->_get_selected_stack('procedures_p');
        foreach ($procedures as $item) {
            $p = Investigations::find($item);
            $p->invoiced = $invoice->id;
            $p->update();
        }
    }

    public function bill_visit(Request $request)
    {
        $split = null;
        $visit = Visit::find($request->visit);
        if (isset($request->split)) {
            $split = $request->split;
        }
        $invoice = $this->createInsuranceInvoice($visit->id, $request->total, $split);
        $this->recordBilledItems($invoice);
        $this->updateVisitStatus($visit->id, 'billed');
        $visit->status = 'billed';
        return $visit->save();
    }

    public function bill_visit_many(Request $request)
    {
        foreach ($request->visit as $i => $visit) {
            $this->updateVisitStatus($request->visit[$i], 'billed');
            $visit = Visit::find($request->visit[$i]);
            $this->createInsuranceInvoice($request->visit[$i], $visit->unpaid_amount);
        }
        return TRUE;
    }

    public function cancel_visit_bill(Request $request)
    {
        $inv = InsuranceInvoice::find($request->id);
        $inv->status = 5;
        return $inv->update();
    }

    public function undoBillCancel(Request $request)
    {
        $inv = InsuranceInvoice::find($request->id);
        $inv->status = 0;
        return $inv->update();
    }

    public function dispatchBills(Request $request)
    {
        return FinanceLibrary::dispatchBills($request);
    }

    public function updateVisitStatus($visit_id, $new_status)
    {
        $visit = Visit::find($visit_id);
        $visit->status = $new_status;
        return $visit->save();
    }

    /**
     * @param $visit
     * @param $amount
     * @return InsuranceInvoice
     */
    public function createInsuranceInvoice($visit, $amount, $split = null)
    {
        $inv = new InsuranceInvoice;
        $inv->invoice_no = 'INV' . time();
        $inv->visit = $visit;
        $inv->payment = $amount;
        $_v = Visit::find($visit);
        $scheme = @$_v->patient_scheme->schemes;
        $inv->company_id = @$scheme->company;
        $inv->scheme_id = @$scheme->id;
        $copay = $scheme->type === 3;
        $inv->split_id = $split;
        $inv->save();
        if ($copay) {
            $this->matchCopay($inv, $_v);
        }
        return $inv;
    }

    /**
     * @param InsuranceInvoice $inv
     * @param Visit $visit
     * @return bool
     */
    private function matchCopay(InsuranceInvoice $inv, Visit $visit)
    {
        $_c = Copay::whereVisitId($visit->id)->first();
        if (!empty($_c->invoice_id)) {
            return true;
        }
        $_c->invoice_id = $inv->id;
        return $_c->save();
    }

    public function swapBill(Request $request)
    {
        \DB::beginTransaction();
        $drugs = $this->_get_selected_stack('drugs_d');
        foreach ($drugs as $drug) {
            $p = Prescriptions::find($drug);
            $cost = $p->drugs->cash_price;
            $attributes = [
                'price' => $cost,
                'cost' => $cost * (int)$p->payment->quantity,
            ];
            $p->payment()->update($attributes);
            $payload = [
                'visit_id' => $request->visit,
                'prescription_id' => $drug,
                'mode' => 'cash',
                'user_id' => $request->user()->id,
                'amount' => $attributes['cost'],
            ];
            ChangeInsurance::create($payload);
        }

        $procedures = $this->_get_selected_stack('procedures_p');
        foreach ($procedures as $drug) {
            $p = Investigations::find($drug);
            $p->price = $p->procedures->cash_charge;
            $p->amount = $p->price * $p->quantity;
            $p->save();
            $payload = [
                'visit_id' => $request->visit,
                'procedure_id' => $drug,
                'mode' => 'cash',
                'user_id' => $request->user()->id,
                'amount' => $p->amount,
            ];
            ChangeInsurance::create($payload);
        }
        reload_payments();
        \DB::commit();
        return true;
    }


    public function saveSplitBill(Request $request)
    {

        $drugs = $this->_get_selected_stack('drugs_d');
        $parent = new SplitInsurance();
        $parent->visit_id = $request->visit;
        $parent->scheme = $request->scheme;
        $parent->user_id = $request->user()->id;
        $parent->save();

        foreach ($drugs as $drug) {
            $payload = [
                'visit_id' => $request->visit,
                'parent_id' => $parent->id,
                'prescription_id' => $drug,
                'mode' => 'insurance',
                'user_id' => $request->user()->id,
            ];
            SplitInsuranceItems::create($payload);
        }

        $procedures = $this->_get_selected_stack('investigation');
        foreach ($procedures as $item) {
            $payload = [
                'visit_id' => $request->visit,
                'parent_id' => $parent->id,
                'investigation_id' => $item,
                'mode' => 'insurance',
                'user_id' => $request->user()->id,
            ];
            SplitInsuranceItems::create($payload);
        }
        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPending()
    {
        $request = \request();
        $pending = PaymentManifest::whereType('insurance')->orderBy('date', 'DESC');
        if ($request->has('company')) {
            $pending = $pending->where('company_id', $request->company);
        }
        if ($request->has('scheme')) {
            $pending = $pending->where('scheme_id', $request->scheme);
        }
        if ($request->has('date1')) {
            $pending = $pending->where('date', '>=', $request->date1);
        }
        if ($request->has('date2')) {
            $date = Carbon::parse($request->date2)->endOfDay()->toDateTimeString();
            $pending = $pending->where('date', '<=', $date);
        }
        return $pending->paginate(100);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBilledInvoices()
    {
        $request = \request();
        $pending = InsuranceInvoice::orderBy('created_at', 'DESC');
        if ($request->has('company')) {
            $pending = $pending->where('company_id', $request->company);
        }
        if ($request->has('scheme')) {
            $pending = $pending->where('scheme_id', $request->scheme);
        }
        if ($request->has('date1')) {
            $pending = $pending->where('created_at', '>=', $request->date1);
        }
        if ($request->has('date2')) {
            $date = Carbon::parse($request->date2)->endOfDay()->toDateTimeString();
            $pending = $pending->where('created_at', '<=', $date);
        }
        return $pending->paginate(100);
    }

    public function getDispatchedInvoices()
    {
        $request = \request();
        $pending = InsuranceInvoice::orderBy('created_at', 'DESC')->whereStatus(1);
        if ($request->has('company')) {
            $pending = $pending->where('company_id', $request->company);
        }
        if ($request->has('scheme')) {
            $pending = $pending->where('scheme_id', $request->scheme);
        }
        if ($request->has('date1')) {
            $pending = $pending->where('created_at', '>=', $request->date1);
        }
        if ($request->has('date2')) {
            $date = Carbon::parse($request->date2)->endOfDay()->toDateTimeString();
            $pending = $pending->where('created_at', '<=', $date);
        }
        return $pending->paginate(100);
    }

    public function getInvoiceByStatus($status = null, $who = null)
    {
        $request = \request();
        $pending = InsuranceInvoice::orderBy('created_at', 'DESC');
        if (!empty($status)) {
            $pending = $pending->whereStatus($status);
        }
        if ($request->has('company')) {
            $pending = $pending->where('company_id', $request->company);
        }
        if ($who) {
            $pending = $pending->where('company_id', $who);
        }
        if ($request->has('scheme')) {
            $pending = $pending->where('scheme_id', $request->scheme);
        }
        if ($request->has('date1')) {
            $pending = $pending->where('created_at', '>=', $request->date1);
        }
        if ($request->has('date2')) {
            $date = Carbon::parse($request->date2)->endOfDay()->toDateTimeString();
            $pending = $pending->where('created_at', '<=', $date);
        }
        return $pending->paginate(100);
    }

    public function getPaidInvoices()
    {
        $request = \request();
        $pending = PaymentsCheque::where('insurance_payment', '>', 0)
            ->orderBy('created_at', 'DESC');
        if ($request->has('company')) {
            $pending = $pending->whereHas('insurance_payments', function (Builder $query) use ($request) {
                $query->where('company', $request->company);
            });
        }
        if ($request->has('scheme')) {
//            $pending = $pending->where('scheme_id', $request->scheme);
        }
        if ($request->has('date1')) {
            $pending = $pending->where('created_at', '>=', $request->date1);
        }
        if ($request->has('date2')) {
            $date = Carbon::parse($request->date2)->endOfDay()->toDateTimeString();
            $pending = $pending->where('created_at', '<=', $date);
        }
        return $pending->paginate(100);
    }

    public function companyStatements()
    {
        $request = \request();
        $pending = InsuranceInvoicePayment::orderBy('created_at', 'DESC');
        if ($request->has('company')) {
            $pending = $pending->whereHas('invoice.scheme', function (Builder $query) use ($request) {
                $query->where('company', $request->company);
            });
        }
        if ($request->has('scheme')) {
            $pending = $pending->whereHas('invoice.scheme', function (Builder $query) use ($request) {
                $query->where('id', $request->scheme);
            });
        }
        if ($request->has('date1')) {
            $pending = $pending->where('created_at', '>=', $request->date1);
        }
        if ($request->has('date2')) {
            $date = Carbon::parse($request->date2)->endOfDay()->toDateTimeString();
            $pending = $pending->where('created_at', '<=', $date);
        }
        return $pending->paginate(100);
    }

    /**
     * @param Request $request
     * @param $item
     * @param EvaluationPayments $payment
     * @return bool
     */
    private function chargeSheetPayment(Request $request, $item, EvaluationPayments $payment): bool
    {
        if (is_module_enabled('Inpatient')) {
            $cs = ChargeSheet::find($item);
            $visit = 'visits' . $item;
            $detail = new EvaluationPaymentsDetails;
            $detail->price = $cs->price;
            $detail->cs_id = $item;
            $detail->visit = $request->$visit;
            $detail->payment = $payment->id;
            $detail->cost = $cs->price;
            $detail->save();
            $cs->paid = true;
            return $cs->save();
        }
        return true;
    }
}
