<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Finance\Entities\BankAccount;
use Ignite\Finance\Entities\PettyCash;
use Ignite\Finance\Entities\RemovedBills;
use Ignite\Finance\Library\Payments\Core\Exceptions\ApiException;
use Ignite\Finance\Repositories\Jambo;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class APIController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function bankAccounts(Request $request)
    {
        $bank_accounts = BankAccount::where('bank', '=', $request->bank)->pluck('number', 'id');
        return Response::json($bank_accounts);
    }

    public function cancelBill()
    {

    }

    public function checkWalletExist(Jambo $jamboPay, $patient_id)
    {
        $patient = Patients::find($patient_id);
        try {
            return \response()->json(['exist' => $jamboPay->checkPatientHasWallet($patient), 'success' => true,]);
        } catch (ApiException $e) {
            return \response()->json(['error' => $e->getMessage(), 'success' => false]);
        }
    }

    public function createWallet(Jambo $jamboPay, $patient_id)
    {
        $patient = Patients::find($patient_id);
        $pin = \request('pin') ?? null;
        try {
            return \response()->json([
                'wallet' => $jamboPay->createWalletForPatient($patient, $pin),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return \response()->json(['error' => $e->getMessage(), 'success' => false]);
        }
    }

    public function postBill(Jambo $jamboPay, Request $request, $patient_id)
    {
        $patient = Patients::find($patient_id);
        try {
            return \response()->json([
                'wallet' => $jamboPay->postBillForPatient($patient, $request->amount),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return \response()->json(['error' => $e->getMessage(), 'success' => false]);
        }
    }

    public function checkBogusWidthrawal()
    {
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

    public function RemoveBill(Request $request)
    {
        try {
            $removal = new RemovedBills();
            $removal->user = \Auth::user()->id;
            if ($request->type == 'investigation') {
                $removal->visit = $request->visit;
                $removal->investigation = $request->id;
            } elseif ($request->type == 'sale') {
                $removal->sale = $request->id;
            } elseif ($request->type == 'dispensing') {
                $removal->visit = $request->visit;
                $removal->dispensing = $request->id;
            } else {
                //stranger
            }
            $removal->save();
            return 'bill removed';
        } catch (\Exception $e) {

        }
    }

    public function UndoRemoveBill(Request $request)
    {
        try {
            if ($request->type == 'investigation') {
                $r = RemovedBills::whereInvestigation($request->id)->get();
            } elseif ($request->type == 'sale') {
                $r = RemovedBills::whereSale($request->id)->get();
            } elseif ($request->type == 'dispensing') {
                $r = RemovedBills::whereDispensing($request->id)->get();
            } else {
                //stranger
            }
            foreach ($r as $item) {
                $item->delete();
            }
            return 'Removal Undone';
        } catch (\Exception $e) {

        }
    }

}
