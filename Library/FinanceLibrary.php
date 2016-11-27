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

use Ignite\Finance\Entities\FinanceAccountGroup;
use Ignite\Finance\Entities\FinanceAccountType;
use Ignite\Finance\Entities\FinanceGlAccounts;
use Ignite\Finance\Entities\PettyCash;
use Ignite\Finance\Entities\PettyCashUpdates;
use Ignite\Finance\Entities\Bank;
use Ignite\Finance\Entities\BankAccount;
use Ignite\Finance\Entities\Banking;
use Ignite\Finance\Entities\BankingCheque;
use Ignite\Finance\Entities\FinanceInvoicePayment;
use Ignite\Finance\Repositories\FinanceRepository;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\Dispatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Description of FinanceFunctions
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class FinanceLibrary implements FinanceRepository {

    /**
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public static function add_gl_group(Request $request, $id = null) {
        $group = FinanceAccountGroup::findOrNew($id);
        $group->name = $request->group;
        $group->type = $request->type;
        return $group->save();
    }

    public static function add_gl_account_types(Request $request, $id = null) {
        $group = FinanceAccountType::findOrNew($id);
        $group->name = $request->name;
        $group->description = $request->description;
        return $group->save();
    }

    public static function add_gl_accounts(Request $request, $id = null) {
        $group = FinanceGlAccounts::findOrNew($id);
        $group->name = $request->name;
        $group->group = $request->group;
        return $group->save();
    }

///
    public static function update_petty_cash(Request $request) {
        $p = PettyCash::firstOrCreate(['id' => 1]);
        $type = $request->type;
        if ($type == 'new') {
            $p->amount = $request->amount;
            $p->save();
            return self::recordPettyUpdates($request, 'new');
        } elseif ($type == 'deposit') {
            $p->amount += $request->amount;
            $p->save();
            return self::recordPettyUpdates($request, 'deposit');
        } else {
            $p->amount -= $request->amount;
            $p->save();
            return self::recordPettyUpdates($request, 'widthrawal');
        }
    }

    public static function update_bank(Request $request) {
        if (isset($request->id)) {
            $b = Bank::find($request->id);
        } else {
            $b = new Bank();
        }
        $b->name = $request->bank;
        $b->save();
    }

    public static function update_banking(Request $request) {
        $b = new Banking();
        $b->bank = $request->bank;
        $b->account = $request->account;
        $b->user = \Auth::user()->id;
        $b->amount = $request->amount;
        $b->type = $request->type;
        $b->mode = $request->mode;
        $b->save();
        self::updateBalance($b->account, $b->type, $b->amount);

        if ($request->mode == 'cheque') {
            self::saveCheque($b->id, $request);
        }
    }

    public static function saveCheque($banking, $request) {
        $cheq = new BankingCheque();
        $cheq->holder_name = $request->ChequeName;
        $cheq->banking = $banking;
        $cheq->cheque_number = $request->ChequeNumber;
        $cheq->cheque_date = new \Date($request->ChequeDate);
        $cheq->bank = $request->Bank;
        $cheq->branch = $request->Branch;
        $cheq->save();
    }

    public static function updateBalance($accnt, $type, $amnt) {
        $account = BankAccount::find($accnt);
        $bal = $account->balance;
        if ($type == 'deposit') {
            $new_bal = $bal+=$amnt;
        } elseif ($type == 'widthrawal') {
            $new_bal = $bal-=$amnt;
        }
        $account->balance = $new_bal;
        $account->save();
    }

    public static function updatePettyBalance($type, $amnt) {
        if (!$account = PettyCash::first()) {
            $petty = new PettyCash();
            $petty->amount = 0.00;
            $petty->save();
            $bal = $petty->amount;
        } else {
            $account = PettyCash::first();
            $bal = $account->amount;
        }

        if ($type == 'deposit') {
            $new_bal = $bal+=$amnt;
        } elseif ($type == 'widthrawal') {
            $new_bal = $bal-=$amnt;
        }
        $account->amount = $new_bal;
        $account->save();
    }

    public static function recordPettyUpdates(Request $request, $type) {
        $p_update = new PettyCashUpdates();
        $p_update->user = \Auth::user()->id;
        $p_update->amount = $request->amount;
        $p_update->type = $type;
        $p_update->reason = $request->reason;
        return $p_update->save();
    }

    public static function update_bank_account(Request $request) {
        $acnt = new BankAccount();
        $acnt->name = $request->name;
        $acnt->number = $request->number;
        $acnt->bank = $request->bank;
        $acnt->balance = $request->balance;
        $acnt->save();
    }

    public static function edit_baccount(Request $request, $id) {
        $acnt = BankAccount::find($id);
        $acnt->name = $request->name;
        $acnt->number = $request->number;
        $acnt->bank = $request->bank;
        $acnt->balance = $request->balance;
        $acnt->update();
    }

    public static function save_payment(Request $request) {
        $pay = new FinanceInvoicePayment;
        $pay->user = \Auth::user()->id;
        if ($request->account != '') {
            $pay->account = $request->account;
        }
        $pay->mode = $request->payment_mode;
        $pay->amount = $request->amount;
        $pay->save();

        if (isset($request->grn_id)) {
            $pay->grn = $request->grn_id;
            $pay->save();
            self::update_grn_payment_status($pay->grn);
        } elseif (isset($request->invoice_id)) {
            $pay->invoice = $request->invoice_id;
            $pay->grn = $request->inv_grn;
            $pay->save();
            self::update_invoice_payment_status($request);
        }

        if ($request->payment_mode == 'account') {
            self::updateBalance($pay->account, 'widthrawal', $pay->amount);
        } elseif ($request->payment_mode == 'petty') {
            self::updatePettyBalance('widthrawal', $request->amount);
            self::recordPettyUpdates($request, 'widthrawal');
        }
        return 1;
    }

    public static function update_grn_payment_status($id) {
        $delivery = InventoryBatch::find($id);
        $delivery->payment_status = 1;
        return $delivery->update();
    }

    public static function update_invoice_payment_status($request) {
        //update grn payment status
        $delivery = InventoryBatch::find($request->inv_grn);
        $paid = $request->paid_amount + $request->amount;
        if (ceil($request->grn_amount) <= $paid) {
            $delivery->payment_status = 1; //fully paid
        } elseif ($request->grn_amount > $paid) {
            $delivery->payment_status = 2; //partially paid
        }
        $delivery->update();
        //update invoice payment status
        $invoice = InventoryInvoice::find($request->invoice_id);
        if ($request->inv_amount <= $paid) {
            $invoice->status = 'paid';
        } elseif ($request->inv_amount >= $paid) {
            $invoice->status = 'partially paid';
        }
        return $invoice->update();
    }

    public static function dispatchBills(Request $request) {
        DB::beginTransaction();
        try {
            foreach ($request->bill as $index => $invoice) {
                $inv = InsuranceInvoice::find($invoice);
                $inv->status = 1;
                $inv->save();

                $dispatch = new Dispatch();
                $dispatch->insurance_invoice = $invoice;
                $dispatch->user = \Auth::user()->id;
                $dispatch->amount = $request->amount[$index];
                $dispatch->save();
            }
            DB::commit();
            //return true;
        } catch (\Exception $e) {
            DB::rollback();
            flash()->warning("Select at least one bill to proceed... thank you");
        }//Catch
    }

}
