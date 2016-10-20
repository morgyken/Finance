<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Finance\Entities\FinanceAccountGroup;
use Ignite\Finance\Entities\FinanceAccountType;
use Ignite\Finance\Entities\FinanceGlAccounts;
use Ignite\Finance\Entities\Bank;
use Ignite\Finance\Entities\BankAccount;
use Ignite\Finance\Entities\Banking;
use Ignite\Finance\Entities\PettyCash;
use Ignite\Finance\Entities\PettyCashUpdates;
use Ignite\Finance\Library\FinanceFunctions;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Finance\Entities\FinanceInvoicePayment;
use Illuminate\Http\Request;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Inventory\Entities\InventoryDispensing;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Finance\Entities\insurance_invoice_payment;

class GlController extends \Ignite\Core\Http\Controllers\AdminBaseController {

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function account_groups($id = null) {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::add_gl_group($this->request, $id)) {
                return redirect()->route('finance.gl.account_groups')->with('success', 'Account group saved');
            }
        }
        $this->data['groups'] = FinanceAccountGroup::all();
        $this->data['group'] = FinanceAccountGroup::findOrNew($id);
        return view('finance::gl.account_groups')->with('data', $this->data);
    }

    public function account_types($id = null) {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::add_gl_account_types($this->request, $id)) {
                return redirect()->route('finance.gl.account_types')->with('success', 'Account type saved');
            }
        }
        $this->data['groups'] = FinanceAccountType::all();
        $this->data['group'] = FinanceAccountType::findOrNew($id);
        return view('finance::gl.account_types')->with('data', $this->data);
    }

    public function accounts($id = null) {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::add_gl_accounts($this->request, $id)) {
                return redirect()->route('finance.gl.accounts')->with('success', 'GL Account saved');
            }
        }
        $this->data['groups'] = FinanceGlAccounts::all();
        $this->data['group'] = FinanceGlAccounts::findOrNew($id);
        return view('finance::gl.accounts')->with('data', $this->data);
    }

    public function bank() {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::update_bank($this->request)) {
                flash('Bank update saved');
                return redirect()->route('finance.gl.banks');
            }
        }
        $this->data['banks'] = Bank::all();
        return view('finance::banks')->with('data', $this->data);
    }

    public function bankEdit($id) {
        $this->data['bank'] = Bank::find($id);
        $this->data['banks'] = Bank::all();
        $this->data['editMode'] = 1;
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::update_bank($this->request)) {
                flash('Bank update saved');
                return view('finance::banks')->with('data', $this->data);
            }
        }
        return view('finance::banks')->with('data', $this->data);
    }

    public function bankDelete($id) {
        $b = Bank::find($id);
        if ($b->delete()) {
            flash('Bank deleted...');
        }
        $this->data['banks'] = Bank::all();
        return view('finance::banks')->with('data', $this->data);
    }

    public function bankAccount() {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::update_bank_account($this->request)) {
                flash('Bank account update saved');
                return redirect()->route('finance.gl.bank.accounts');
            }
        }
        $this->data['accounts'] = BankAccount::all();
        $this->data['banks'] = Bank::all();
        return view('finance::bank_account')->with('data', $this->data);
    }

    public function bankAccountEdit($id) {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::edit_baccount($this->request, $id)) {
                flash('Bank account update saved');
                return redirect()->route('finance.gl.bank.accounts');
            }
        }
        $this->data['edit_mode'] = 1;
        $this->data['account'] = BankAccount::find($id);
        $this->data['accounts'] = BankAccount::all();
        $this->data['banks'] = Bank::all();
        return view('finance::bank_account')->with('data', $this->data);
    }

    public function bankAccountDelete($id) {
        $b = BankAccount::find($id);
        if ($b->delete()) {
            flash('Bank Account deleted...');
        }
        $this->data['account'] = BankAccount::find($id);
        $this->data['accounts'] = BankAccount::all();
        $this->data['banks'] = Bank::all();
        return view('finance::bank_account')->with('data', $this->data);
    }

    public function banking() {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::update_banking($this->request)) {
                flash('Banking update saved');
                return redirect()->route('finance.gl.banking');
            }
        }
        $this->data['bankings'] = Banking::all();
        $this->data['banks'] = Bank::all();
        $this->data['accounts'] = BankAccount::all();
        return view('finance::banking')->with('data', $this->data);
    }

    public function banking_trash($id) {
        $b = Banking::find($id);
        if ($b->delete()) {
            flash('Banking deleted...');
        }
        $this->data['bankings'] = Banking::all();
        $this->data['banks'] = Bank::all();
        $this->data['accounts'] = BankAccount::all();
        return view('finance::banking')->with('data', $this->data);
    }

    public function pettyCash() {
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::update_petty_cash($this->request)) {
                flash('Pettycash update saved');
                return redirect()->route('finance.gl.pettycash');
            }
        }
        $this->data['petty'] = PettyCash::first();
        $this->data['petty_updates'] = PettyCashUpdates::all();
        return view('finance::petty_cash')->with('data', $this->data);
    }

    public function payment() {
        $this->data['accounts'] = BankAccount::all();
        $this->data['pay'] = FinanceInvoicePayment::all();
        $this->data['del'] = InventoryBatch::find($this->request->id);
        $purchases = InventoryBatchPurchases::query();
        $this->data['items'] = $purchases->where('batch', '=', $this->request->id)->get();
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::save_payment($this->request)) {
                flash('Payment saved');
                return \Redirect::back();
            }
        }
        return \Redirect::back();
    }

    public function payments() {
        if (isset($this->request->id)) {
            $this->data['pay'] = FinanceInvoicePayment::find($this->request->id);
            return view('finance::gl.payment_details')->with('data', $this->data);
        } else {
            $this->data['pay'] = FinanceInvoicePayment::all();
            return view('finance::payments')->with('data', $this->data);
        }
    }

    public function dispatchbills() {
        $this->data['insurance_invoices'] = InsuranceInvoice::all();
        //dd($this->request);
        if ($this->request->isMethod('post')) {
            if (FinanceFunctions::dispatchBills($this->request)) {
                flash('Bills dispatched');
                return redirect()->route('finance.billing');
            }
        }
        return redirect()->back();
    }

    public function cancelBill() {
        $bill = InsuranceInvoice::find($this->request->id);
        $bill->status = 3; //cancelled
        $bill->save();
        flash('Bill cancelled successfully...');
        return redirect()->back();
    }

    public function payBill() {
        $this->data['bill'] = InsuranceInvoice::find($this->request->id);
        $batch_sale = InventoryBatchProductSales::where('receipt', '=', $this->data['bill']->invoice_no)->first();
        $batch = $batch_sale->id;
        $sold = InventoryDispensing::where('batch', '=', $batch)->get();
        $amnt = 0;
        foreach ($sold as $s) {
            $price = $s->price * $s->quantity;
            $amnt+=$price;
        }
        $this->data['amnt'] = $amnt;
        return view("finance::paybill")->with('data', $this->data);
    }

    public function savePayBill() {
        $bill = InsuranceInvoice::find($this->request->id);
        $bill->status = 2; //cancelled
        $bill->save();

        $sale = InventoryBatchProductSales::where('receipt', '=', $bill->invoice_no)->first();
        $sale->paid = TRUE;
        $sale->save();

        $payment = new insurance_invoice_payment();
        $payment->insurance_invoice = $this->request->id;
        $payment->user = \Auth::user()->id;
        $payment->amount = $this->request->amount;
        $payment->mode = $this->request->mode;
        $payment->save();
        flash('Payment saved successfully...');
        return redirect()->back();
    }

    public function print_bill(Request $request) {
        $bill = InsuranceInvoice::findOrFail($request->id);
        $batch_sale = InventoryBatchProductSales::where('receipt', '=', $bill->invoice_no)->first();
        $batch = $batch_sale->id;
        $sold = InventoryDispensing::where('batch', '=', $batch)->get();

        $pdf = \PDF::loadView('finance::prints.bill', ['bill' => $bill, 'sold' => $sold]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
    }

}
