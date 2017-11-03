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
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Finance\Entities\ChangeInsurance;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Finance\Entities\PatientTransaction;
use Ignite\Finance\Entities\PaymentManifest;
use Ignite\Finance\Entities\PaymentsCard;
use Ignite\Finance\Entities\PaymentsCash;
use Ignite\Finance\Entities\PaymentsCheque;
use Ignite\Finance\Entities\PaymentsMpesa;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Inventory\Entities\InventoryProducts;
use Illuminate\Database\Eloquent\Builder;
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
use Ignite\Finance\Entities\PatientInvoice;
use Ignite\Finance\Entities\PatientInvoiceDetails;

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
        DB::transaction(function () {
            $stock = $this->_get_selected_stack();

            foreach ($stock as $item) {
                $this->updatePrescriptions($item);
            }
            if (isset($this->request->batch)) {
                foreach ($this->request->batch as $bitch) {
                    $sale = InventoryBatchProductSales::find($bitch);
                    $sale->paid = 1;
                    $sale->save();
                }
            }

            //Update dispensing details
            if (isset($this->request->dispense)) {
                foreach ($this->request->dispense as $disp) {
                    $sale = DispensingDetails::find($disp);
                    $sale->status = 1;
                    $sale->save();
                }
            }

            $payment = new EvaluationPayments;
            $p = \Ignite\Reception\Entities\Patients::find($this->request->patient);
            if (!is_null($p)) {
                $payment->patient = $this->request->patient;
            }
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
        });
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

            $__items = $this->__get_selected_stack();
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
        $items = $this->__get_selected_stack();
        foreach ($items as $item) {
            $invoice = 'invoice' . $item;
            if (isset($request->$invoice)) {
                $this->invoice_payment_details($item, $payment);
            } else {
                if ($this->isDrugPayment($item)) {
                    $this->drug_payment_details($request, $item, $payment);
                } else {
                    $this->investigation_payment_details($request, $item, $payment);
                }
            }
        }
    }

    private function isDrugPayment($item)
    {
        if ($this->request->has('type' . $item)) {
            return (\request('type' . $item) == 'pharmacy');
        }
        return false;
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

    private function payment_methods(EvaluationPayments $payment)
    {
        $paid_amount = 0;
        if ($this->request->has('CashAmount')) {
            $paid_amount += $this->input['CashAmount'];
            PaymentsCash::create([
                'amount' => $this->input['CashAmount'],
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('MpesaAmount')) {
            $paid_amount += $this->input['MpesaAmount'];
            $code = null;
            if (isset($this->input['MpesaCode'])) {
                $code = $this->input['MpesaCode'];
            }
            PaymentsMpesa::create([
                'amount' => $this->input['MpesaAmount'],
                'reference' => $code,
                'payment' => $payment->id,
            ]);
        }
        if ($this->request->has('CardAmount')) {
            $paid_amount += $this->input['CardAmount'];

            $type = null;
            $name = null;
            $number = null;
            $expiry = null;

            try {
                $type = $this->input['CardType'];
                $name = $this->input['CardNames'];
                $number = $this->input['CardNumber'];
                $expiry = $this->input['CardExpiry'];
            } catch (\Exception $ex) {
                //
            }


            PaymentsCard::create([
                'type' => $type,
                'name' => $name,
                'number' => $number,
                'expiry' => $expiry,
                'amount' => $this->input['CardAmount'],
                'security' => '000',
                'payment' => $payment->id
            ]);
        }
        if ($this->request->has('ChequeAmount')) {
            $paid_amount += $this->input['ChequeAmount'];

            $ChequeName = null;
            $ChequeDate = null;
            $ChequeBank = null;
            $ChequeBankBranch = null;
            $ChequeNumber = null;

            try {
                $ChequeName = $this->input['ChequeName'];
                $ChequeDate = $this->input['ChequeDate'];
                $ChequeBank = $this->input['ChequeBank'];
                $ChequeBankBranch = $this->input['ChequeBankBranch'];
                $ChequeNumber = $this->input['ChequeNumber'];
            } catch (\Exception $ex) {

            }

            PaymentsCheque::create([
                'name' => $ChequeName,
                'date' => $ChequeDate,
                'amount' => $this->input['ChequeAmount'],
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
        $cheque->name = $this->input['ChequeName'] ? strtoupper($this->input['ChequeName']) : '';
        $cheque->date = $this->input['ChequeDate'] ? new \Date($this->input['ChequeDate']) : '';
        $cheque->amount = $this->input['ChequeAmount'];
        $cheque->bank = $this->input['ChequeBank'] ? $this->input['ChequeBank'] : '';
        $cheque->bank_branch = $this->input['ChequeBankBranch'] ? $this->input['ChequeBankBranch'] : '';
        $cheque->number = $this->input['ChequeNumber'] ? $this->input['ChequeNumber'] : '';
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
     * @return array
     */
    private function __get_selected_stack()
    {
        $stack = [];
        foreach ($this->input as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
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
        $visit = Visit::find($request->visit);
        $invoice = $this->createInsuranceInvoice($visit->id, $request->total);
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
    public function createInsuranceInvoice($visit, $amount)
    {
        $inv = new InsuranceInvoice;
        $inv->invoice_no = 'INV' . time();
        $inv->visit = $visit;
        $inv->payment = $amount;
        $_v = Visit::find($visit);
        $inv->company_id = @$_v->patient_scheme->schemes->company;
        $inv->scheme_id = @$_v->patient_scheme->schemes->id;
        $inv->save();
        return $inv;
    }

    public function swapBill(Request $request)
    {
        $drugs = $this->_get_selected_stack('drugs_d');
        foreach ($drugs as $drug) {
            $p = InventoryProducts::find($drug);
            $payload = [
                'visit_id' => $request->visit,
                'prescription_id' => $drug,
                'mode' => 'cash',
                'user_id' => $request->user()->id,
                'amount' => $p->cash_price,
            ];
            ChangeInsurance::create($payload);
        }

        $procedures = $this->_get_selected_stack('procedures_p');
        foreach ($procedures as $drug) {
            $p = Procedures::find($drug);
            if(!empty($p)){
                $payload = [
                    'visit_id' => $request->visit,
                    'procedure_id' => $drug,
                    'mode' => 'cash',
                    'user_id' => $request->user()->id,
                    'amount' => $p->price,
                ];
                ChangeInsurance::create($payload);
            }
        }
        reload_payments();
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
        return $pending->get();
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
        return $pending->get();
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
        return $pending->get();
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
        return $pending->get();
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
        return $pending->get();
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
        return $pending->get();
    }
}
