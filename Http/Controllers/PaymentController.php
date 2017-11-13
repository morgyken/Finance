<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Evaluation\Repositories\PaymentsRepository;

class PaymentController extends AdminBaseController
{
    protected $paymentsRepository;

    /*
    * Inject the payment repo
    */
    public function __construct(PaymentsRepository $paymentsRepository)
    {
        parent::__construct();
        
        $this->paymentsRepository = $paymentsRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('finance::payments.index');
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
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $payment = $this->paymentsRepository->find($id);

        $total = $this->paymentsRepository->total();

        $modes = $this->paymentsRepository->modes();

        return view('finance::payments.show', compact('payment', 'modes', 'total'));
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
