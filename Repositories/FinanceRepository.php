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
interface FinanceRepository
{
    /**
     * Process transaction check
     * @param object $data
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function processCallback($data);
}
