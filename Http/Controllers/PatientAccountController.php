<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Reception\Entities\Patients;
use Ignite\Finance\Repositories\PaymentsRepository;
use Ignite\Finance\Repositories\PatientAccountRepository;

class PatientAccountController extends AdminBaseController
{
    protected $patientAccountRepository, $paymentRepository;
    
    public function __construct(PatientAccountRepository $patientAccountRepository,
                                PaymentsRepository $paymentRepository)
    {
        parent::__construct();

        $this->patientAccountRepository = $patientAccountRepository;

        $this->paymentRepository = $paymentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($patientId)
    {
        $patient = Patients::with(['account'])->findOrFail($patientId);

        return view('finance::accounts.index', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
    * @return Response
     */
    public function store()
    {
        if(request()->has('insurance') && is_module_enabled('Inpatient'))
        {
            \Ignite\Inpatient\Entities\InsuranceMaximumAmount::create(
                request()->get('insurance')
            );
        }

        $paymentDetails = request()->only(['patient']);

        $payment = $this->paymentRepository->save($paymentDetails);

        $account = $this->patientAccountRepository->deposit($payment->id);

        if(request()->ajax())
        {
            return response()->json([
                'data' => $account
            ]);
        }
        else
        {
            return redirect()->route('finance.account.deposit.done', $payment->id);
        }
    }
}
