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
use Nwidart\Modules\Routing\Controller;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Finance\Entities\FinanceInvoicePayment;
use Illuminate\Http\Request;

class GlController extends Controller {

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

}
