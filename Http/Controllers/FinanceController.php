<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Repositories\EvaluationRepository;
use Illuminate\Http\Request;

class FinanceController extends AdminBaseController
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

    public function billing()
    {
        $this->data['insurance_invoices'] = InsuranceInvoice::all();
        return view('finance::billing', ['data' => $this->data]);
    }

    public function swapModes(Request $request)
    {
        if ($this->evaluationRepository->swapBill($request)) {
            flash('That was done');
//            return redirect()->route('finance.evaluation.billed');
        } else {
            flash()->error('Could not do that!');
        }
        return back();
    }

    public function bill(Request $request)
    {
        if ($this->evaluationRepository->bill_visit($request)) {
            flash('Bill placed, thank you');
            return redirect()->route('finance.evaluation.billed');
        } else {
            flash()->error('Bill could not be placed');
            return back();
        }
    }
}
