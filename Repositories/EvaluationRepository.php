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

namespace Ignite\Finance\Repositories;

use Illuminate\Http\Request;

/**
 * Description of FinanceRepository
 *
 * @author samuel
 */
interface EvaluationRepository
{

    /**
     * Record payment
     * @return bool
     */
    public function record_payment();

    /**
     * @param Request $request
     * @return mixed
     */
    public function bill_visit_many(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function bill_visit(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function swapBill(Request $request);

    /**
     * @return mixed
     */
    public function getPending();


    /**
     * @param int|null $status
     * @param int|null $who
     * @return mixed
     */
    public function getInvoiceByStatus($status = null, $who = null);

    public function record_insurance_payment();

    public function getPaidInvoices();

    public function companyStatements();

    public function undoBillCancel(Request $request);

    public function dispatchBills(Request $request);
}
