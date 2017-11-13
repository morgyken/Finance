<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Reception\Entities\Patients;
use Ignite\Finance\Repositories\PatientAccountRepository;
use Ignite\Evaluation\Repositories\PaymentsRepository;

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
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
    * @return Response
     */
    public function store()
    {
        $paymentDetails = request()->only(['patient']);

        $payment = $this->paymentRepository->save($paymentDetails);

        $payment->amount = $this->patientAccountRepository->deposit($payment->id);

        $payment->save();

        return redirect()->route('finance.payment', ['payment' => $payment->id]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
