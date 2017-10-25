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
     * @return mixed
     */
    public function getInvoiceByStatus($status = null);
}
