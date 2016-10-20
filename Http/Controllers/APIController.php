<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Finance\Entities\PettyCash;
use Ignite\Finance\Entities\BankAccount;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class APIController extends \Illuminate\Routing\Controller {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function bankAccounts(Request $request) {
        $bank_accounts = BankAccount::where('bank', '=', $request->bank)->pluck('number', 'id');
        return Response::json($bank_accounts);
    }

    public function cancelBill() {

    }

    public function checkBogusWidthrawal() {
        $amount = $this->request->amount;
        $account_type = $this->request->account_type;

        if ($account_type == 'petty') {
            //check petty account
            $petty_account = PettyCash::first();
            if ($petty_account) {
                if ($amount <= $petty_account->amount) {
                    $response = "<i class='fa fa-check' style='color:green'></i>";
                } else {
                    $response = "<i class='fa fa-times' style='color:red'></i>Account overdraw alert! <span class='label label-info'>deposit first</span>";
                }
            } else {
                $response = "<i class='fa fa-times' style='color:red'></i>Case Safe Empty! <span class='label label-info'>Deposit/Set first</span>";
            }
            return $response;
        } else {
            //check bank account
            $bank_account = $this->request->account_id;
            $account = BankAccount::find($bank_account);

            if ($amount <= $account['balance']) {
                $response = "<i class='fa fa-check' style='color:green'></i><span class='label label-success'> " . $account['balance'] . "</span> in account";
            } else {
                $response = "<i class='fa fa-times' style='color:red'></i>Account overdraw alert!<span class='label label-danger'> " . $account['balance'] . "</span> in account <a href='/finance/gl/banking/accounts' target='blank'><span class='label label-info'>add funds to account first</span></a>";
            }
            return $response;
        }
    }

}
