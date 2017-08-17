<?php

namespace Dervis\Library\Payments\Core;

/**
 * Interface Banker
 * @package Dervis\Library\Banker\Core
 */
interface FinanceRepository
{
    /**
     * @param string $amount
     * @return mixed
     */
    public function request($amount);

    /**
     * @param string $account
     * @return mixed
     */
    public function from($account);

    /**
     * Get payment status
     * @return mixed
     */
    public function status();
}