<?php

namespace Ignite\Finance\Repositories;

/**
 * Interface Jambo
 * @package Ignite\Finance\Repositories
 */
interface Jambo
{
    /**
     * @param string $number
     * @return mixed
     */
    public function checkWalletExist($number);

    /**
     * @return mixed
     */
    public function createWallet();
}