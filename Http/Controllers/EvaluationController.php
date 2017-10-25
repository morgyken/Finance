<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\Dispatch;
use Ignite\Finance\Entities\DispatchDetails;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\FinanceEvaluationInsurancePayments;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\InsuranceInvoicePayment;
use Ignite\Finance\Entities\PatientInvoice;
use Ignite\Finance\Entities\PatientTransaction;
use Ignite\Finance\Entities\PaymentManifest;
use Ignite\Finance\Entities\PaymentsCheque;
use Ignite\Finance\Http\Requests\PaymentsRequest;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EvaluationController extends AdminBaseController
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
    }

    public function sale_details(Request $request)
    {
        $this->data['sales'] = InventoryBatchProductSales::find($request->sale);
        return view('finance::evaluation.sale_preview', ['data' => $this->data]);
    }

    public function printA4Receipt(Request $request)
    {
        $this->data['invoice_mode'] = $request->invoice;
        $this->data['payment'] = $payment = EvaluationPayments::find($request->payment);
        $this->data['disp'] = json_decode($payment->dispensing);
        $this->data['a4'] = 1;
        $pdf = \PDF::loadView('finance::evaluation.print.receipt', ['data' => $this->data]);
        $pdf->setPaper('a4', 'Potrait');
        return @$pdf->stream('Bill' . $request->id . '.pdf');
    }

    public function printNormalReceipt(Request $request)
    {
        $this->data['invoice_mode'] = $request->invoice;
        //$this->data['sales'] = InventoryBatchProductSales::find($id);
        $this->data['payment'] = $payment = EvaluationPayments::find($request->payment);
        ///dd($this->data);
        $min_height = 900;
        /*
          foreach ($this->data['pa']->goodies as $n) {
          $min_height += 20;
          } */

        if (isset($payment->visits->investigations)) {
            foreach ($payment->visits->investigations as $i) {
                $min_height += 20;
            }
        }

        if (isset($payment->visits->dispensing)) {
            foreach ($payment->visits->dispensing as $item) {
                foreach ($item->details as $item) {
                    $min_height += 20;
                }
            }
        }

        if (isset($payment->visits->drug_purchases)) {
            foreach ($payment->visits->drug_purchases as $item) {
                foreach ($item->details as $item) {
                    $min_height += 20;
                }
            }
        }

        if ($payment->sale > 0) {
            foreach ($payment->sales->goodies as $item) {
                $min_height += 20;
            }
        }

        $this->data['disp'] = json_decode($payment->dispensing);

        $pdf = \PDF::loadView('finance::evaluation.print.receipt_t', ['data' => $this->data]);
        $customPaper = [0, 0, 300, $min_height];
        $pdf->setPaper($customPaper);
        return @$pdf->stream('receipt_' . $request->payment . '.pdf');
    }

    public function pay_save(PaymentsRequest $request)
    {
        $id = $this->evaluationRepository->record_payment();
        if ($request->invoice_mode) {
            return redirect()->route('finance.evaluation.payment_details', ['id' => $id, 'invoice' => true]);
        } else {
            return redirect()->route('finance.evaluation.payment_details', ['id' => $id]);
        }
    }

    public function pay(Request $request)
    {
        $patient = $request->patient;
        $invoice = $request->invoice;
        if (!empty($patient)) {
            $this->data['invoice_mode'] = $invoice;
            $this->data['deposit'] = $request->deposit;
            $this->data['patient'] = Patients::find($patient);
            $this->data['patient_invoices'] = PatientInvoice::wherePatient_id($patient)->get();
            return view('finance::evaluation.pay', ['data' => $this->data]);
        }
        if (m_setting('finance.background_manifest')) {
            $this->data['manifests'] = PaymentManifest::whereType('cash')->get();
            $this->data['sales'] = InventoryBatchProductSales::wherePaid(0)
                ->doesntHave('removed_bills')
                ->whereNull('insurance')
                ->orderBy('created_at', 'desc')
                ->get();

            $this->data['invoiced'] = Patients::whereHas('invoices', function ($query) {
                $query->whereStatus('unpaid')
                    ->orWhere('status', '=', 'part_paid');
            })->get();
            return view('finance::payment_list', ['data' => $this->data]);
        }
        $this->billable_patients();
        return view('finance::evaluation.payment_list', ['data' => $this->data]);
    }

    public function pharmacy_dispense(Request $request)
    {
        $stack = $this->_get_selected_stack();
        foreach ($stack as $index) {
            $update = [
                'complete' => true,
                'quantity' => \request('qty' . $index),
//                'invoiced' => $request->has('to_redirect'),
            ];
            $prescription = Prescriptions::find($index);
            $prescription->payment()->update($update);
        }
        if ($request->has('to_redirect')) {
            return redirect()->route('finance.evaluation.pending');
        }
        return redirect()->route('finance.evaluation.pay', $request->patient);
    }

    /**
     * Build an index of items dynamically
     * @return array
     */
    private function _get_selected_stack()
    {
        $stack = [];
        $input = \request()->all();
        foreach ($input as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
            }
        }
        return $stack;
    }


    public function payPharmacy($patient)
    {
        $this->data['patient'] = Patients::find($patient);
        $this->data['drugs'] = Prescriptions::whereHas('visits', function (Builder $query) use ($patient) {
            $query->wherePatient($patient);
            $query->whereHas('prescriptions.payment', function (Builder $builder) {
                $builder->wherePaid(false);
                $builder->whereInvoiced(false);
            });
        })->get();
        return view('finance::evaluation.pay-pharmacy', ['data' => $this->data]);
    }

    private function billable_patients()
    {
        $this->data['visits'] = Visit::wherePaymentMode('cash')
            ->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->whereHas('investigations', function ($q3) {
                        $q3->doesntHave('payments');
                        $q3->doesntHave('removed_bills');
                    });
                    $query->orWhereHas('dispensing', function ($q) {
                        $q->doesntHave('removed_bills');
                        $q->whereHas('details', function ($qd) {
                            $qd->whereStatus(0);
                        });
                    });
                    $query->orWhere(function (Builder $query) {
                        $query->whereHas('prescriptions.payment', function (Builder $query) {
                            $query->wherePaid(false);
                        })->orWhereHas('prescriptions', function (Builder $builder) {
                            $builder->whereDoesntHave('payment');
                        });
                    });
                });
            })
            ->orWhere(function (Builder $query) {
                $query->whereHas('to_cash', function (Builder $query) {
                    $query->whereMode('cash');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->reject(function ($value) {
                return empty($value->unpaid_amount);
            });
        $this->data['sales'] = InventoryBatchProductSales::wherePaid(0)
            ->doesntHave('removed_bills')
            ->whereNull('insurance')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->data['invoiced'] = Patients::whereHas('invoices', function ($query) {
            $query->whereStatus('unpaid')
                ->orWhere('status', '=', 'part_paid');
        })->get();

        return $this->data;
    }

//Patient Invoicing
    public function patient_invoice(Request $request, $patient = null)
    {
        if ($request->isMethod('post')) {
            $this->create_patient_invoice($request);
        }
        if (!empty($patient)) {
            $this->data['patient'] = Patients::find($patient);
            return view('finance::evaluation.invoice', ['data' => $this->data]);
        }
        $this->billable_patients();
        return view('finance::evaluation.payment_list', ['data' => $this->data]);
    }

    public function create_patient_invoice(Request $request)
    {
        $id = $this->evaluationRepository->create_patient_invoice();
        //return redirect()->route('finance.evaluation.payment_details', $id);
    }

    public function manage_patient_invoices($id = null)
    {
        if (!empty($id)) {
            $this->data['invoice'] = PatientInvoice::find($id);
            return view('finance::evaluation.view_patient_invoice', ['data' => $this->data]);
        }
        $this->data['invoices'] = PatientInvoice::all();
        return view('finance::evaluation.manage_invoices', ['data' => $this->data]);
    }

    public function purge_patient_invoice($id = null)
    {
        if (!empty($id)) {
            $invoice = PatientInvoice::find($id);
            foreach ($invoice->details as $item) {
                if (!empty($item->investigation_id)) {
                    $i = Investigations::find($item->investigation_id);
                    $i->invoiced = false;
                    $i->save();
                }
                if (!empty($item->dispensing_id)) {
                    $d = Dispensing::find($item->dispensing_id);
                    $d->invoiced = false;
                    $d->save();
                }
            }
            $invoice->delete();
        }
        return redirect()->route('finance.evaluation.patient_invoices');
    }

    public function print_patient_invoice($id = null)
    {
        if (!empty($id)) {
            $invoice = PatientInvoice::find($id);
            $pdf = \PDF::loadView('finance::prints.patient_invoice', ['invoice' => $invoice]);
            $pdf->setPaper('a4', 'potrait');
            return $pdf->stream('Invoice_' . $id . '.pdf');
        }
    }

//End of patient invoicing
    public function payment_details($id, $invoice = null)
    {
        $this->data['invoice_mode'] = $invoice;
        $this->data['payment'] = $payment = EvaluationPayments::find($id);
        $this->data['disp'] = json_decode($payment->dispensing);
        $this->data['patient'] = Patients::find($payment->patient);
        return view('finance::evaluation.details', ['data' => $this->data]);
    }

    public function sale_pay($sale = null)
    {
        if (!empty($sale)) {
            $this->data['sales'] = InventoryBatchProductSales::find($sale);
            return view('finance::evaluation.sale_pay', ['data' => $this->data]);
        }

        $this->data['sales'] = InventoryBatchProductSales::wherePaid(0)
            ->get();

        return view('finance::evaluation.payment_list', ['data' => $this->data]);
    }


    public function individual_account($patient)
    {
        $this->data['payments'] = EvaluationPayments::wherePatient($patient)->get();
        $this->data['transactions'] = PatientTransaction::wherePatient_id($patient)->get();
        $this->data['patient'] = Patients::find($patient);
        return view('finance::individual_account', ['data' => $this->data]);
    }


    public function insurance()
    {
        $this->data['bill_mode'] = 1;
        $this->data['billed'] = InsuranceInvoice::where('visit', '>', 0)
            ->get();
        return view('finance::evaluation.partials.billed', ['data' => $this->data]);
    }

    public function pendingBills()
    {
        $this->data['pending_mode'] = 1;
        if (m_setting('finance.background_manifest')) {
            $this->data['pending'] = $this->evaluationRepository->getPending();
            return view('finance::pending-insurance', ['data' => $this->data]);
        }
        $this->data['pending'] = Visit::wherePaymentMode('insurance')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('finance::evaluation.partials.pending', ['data' => $this->data]);
    }

    public function billedBills()
    {
        $this->data['bill_mode'] = 1;
        $this->data['billed'] = $this->evaluationRepository->getBilledInvoices();
        return view('finance::evaluation.partials.billed', ['data' => $this->data]);
    }

    public function dispatchedInvoices()
    {
        $this->data['dispatch_mode'] = 1;
        $this->data['dispatched'] = $this->evaluationRepository->getDispatchedInvoices();
        return view('finance::evaluation.partials.dispatched', ['data' => $this->data]);
    }

    public function cancelledBills()
    {
        $this->data['cancel_mode'] = 1;
        $this->data['canceled'] = InsuranceInvoice::where('visit', '>', 0)
            ->whereStatus(5)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('finance::evaluation.partials.cancelled', ['data' => $this->data]);
    }

    public function companyInvoicePayment()
    {
        $this->data['payment_mode'] = 1;
        $this->data['billed'] = InsuranceInvoice::where('visit', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('finance::evaluation.partials.payment', ['data' => $this->data]);
    }

    public function paidInvoices()
    {
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

    public function companyStatements(Request $request)
    {
        $this->data['stmt_mode'] = 1;
        $this->data['payments'] = InsuranceInvoicePayment::orderBy('created_at', 'DESC')->get();

        return view('finance::evaluation.partials.firm_statement', ['data' => $this->data]);
    }


    public function prepareBill($visit_id)
    {
        $this->data['visit'] = Visit::find($visit_id);
        return view('finance::prepare-bill', ['data' => $this->data]);
    }

    public function billMany(Request $request)
    {
        if ($this->evaluationRepository->bill_visit_many($request)) {
            flash('Bills placed, thank you');
            return back();
        } else {
            flash('Bills could not be placed, please try again');
            return redirect()->route('finance.evaluation.billed');
        }
    }

    public function cancelBill(Request $request)
    {
        if ($this->evaluationRepository->cancel_visit_bill($request)) {
            flash('Bill cancelled, thank you');
            return back();
        } else {
            flash('Bill could not be cancelled, thank you');
            return back();
        }
    }

    public function undoBillCancel(Request $request)
    {
        if ($this->evaluationRepository->undoBillCancel($request)) {
            flash('Bill cancellation undone successfully, thank you');
            return back();
        } else {
            flash('Bill cancellation could not be undone at this time, please try again');
            return back();
        }
    }

    public function dispatchBill(Request $request)
    {
        if ($this->evaluationRepository->dispatchBills($request)) {
            flash('Bill(s) dispatched, thank you');
            return back();
        } else {
            flash('Bills could not be dispatched, please try again later');
            return back();
        }
    }

    public function summary()
    {
        $this->data['all'] = EvaluationPayments::all();
        return view('finance::evaluation.summary', ['data' => $this->data]);
    }

    public function payInsBill(Request $request)
    {
        $this->data['visit'] = Visit::find($request->visit);
        return view('finance::evaluation.pay_ins_bill', ['data' => $this->data]);
    }

    public function saveInsuranceInvoicePayments(Request $request)
    {
        if (isset($request->company)) {
            $this->evaluationRepository->record_insurance_payment();
            return back();
        } else {
            flash()->error('Select an insurance company to continue');
            return back();
        }
    }

    public function insurancePayment(Request $request)
    {
        $this->data['invoices'] = InsuranceInvoice::where('visit', '>', 0)
            ->whereStatus(1)
            ->get();
        return view('finance::evaluation.insurance_payment', ['data' => $this->data]);
    }

    public function cash_bills()
    {
        $this->data['cash'] = EvaluationPayments::all();
        return view('finance::evaluation.cash_bills', ['data' => $this->data]);
    }

    public function printInvoice(Request $request)
    {
        $bill = InsuranceInvoice::find($request->id);
        $pdf = \PDF::loadView('finance::evaluation.print.invoice', ['bill' => $bill]);
        $pdf->setPaper('a4', 'potrait');
        return @$pdf->stream('Bill' . $request->id . '.pdf');
    }

    public function printReceipt(Request $request)
    {
        $payment = FinanceEvaluationInsurancePayments::find($request->id);
        $pdf = \PDF::loadView('finance::evaluation.print.rcpt', ['payment' => $payment]);
        $pdf->setPaper('a4', 'potrait');
        return @$pdf->stream('Bill' . $request->id . '.pdf');
    }

    public function billToCash(Request $request)
    {
        $visit = Visit::find($request->visit);
        $visit->payment_mode = 'cash';
        $visit->save();
        flash("Bill changed to cash successfully");
        return back();
    }

    public function printDispatch(Request $request)
    {
        $dispatch = Dispatch::find($request->id);
        $pdf = \PDF::loadView('finance::evaluation.print.dispatch', ['dispatch' => $dispatch]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('dispatch_' . $request->id . '.pdf');
    }

    public function purgeDispatch($id)
    {
        $dispatch = DispatchDetails::where('insurance_invoice', $id)->get();
        $item = null;
        foreach ($dispatch as $dis) {
            $inv = InsuranceInvoice::find($dis->insurance_invoice);
            $inv->status = 5;
            $inv->save();
            $item = $dis->dispatch;
        }
        $batch = Dispatch::find($item);
        $batch->delete();
        flash("Dispatch Cancelled");
        return redirect()->route('finance.evaluation.dispatched');
    }

}
