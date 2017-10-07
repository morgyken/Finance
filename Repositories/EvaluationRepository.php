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

    public function bill_visit_many(Request $request);

    public function bill_visit(Request $request);
}
