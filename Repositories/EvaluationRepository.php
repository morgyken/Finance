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

/**
 * Description of FinanceRepository
 *
 * @author samuel
 */
interface EvaluationRepository {

    /**
     * Record payment
     * @return bool
     */
    public function record_payment();
}