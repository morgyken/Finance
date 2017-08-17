<?php

namespace Ignite\Finance\Library\Payments\Core;


use Ignite\Finance\Entities\Transactions;
use Ignite\Finance\Library\Payments\Core\Exceptions\ApiException;
use Ignite\Finance\Library\Payments\Core\Exceptions\TransactionException;
use Ignite\Finance\Library\Payments\Mpesa\Cashier;
use Illuminate\Http\Request;

/**
 * Class Banker
 * @package Dervis\Library\Banker\Core
 */
class Banker
{
    /**
     * @param Request $request
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws \Dervis\Library\Payments\Core\Exceptions\UnknownProvider
     */
    public static function processPayment(Request $request)
    {
        return self::loadCash($request->account, $request->amount, $request->reference, $request->gateway);
    }

    /**
     * Load cash to account
     * @param string $account
     * @param string $amount
     * @param string $gateway
     * @return array
     */
    public static function loadCash($account, $amount, $gateway = 'equity')
    {
        $handler = null;
        try {
            $worker = resolve(Cashier::class);
            $ref = self::getReference();
            $worker->request($amount)
                ->usingReferenceId($ref)
                ->from($account)
                ->transact();
            return ['success' => true, 'message' => 'Payment was requested', 'ref' => $ref];
        } catch (ApiException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get a unique reference
     * @return int
     */
    public static function getReference()
    {
        $id = random_int(100, 99999999);
        $count = Transactions::whereReference($id)->count();
        if (!empty($count)) {
            return self::getReference();
        }
        return $id;
    }

    /**
     * @param $ref
     * @param $gateway
     * @return array
     */
    public static function getStatus($ref, $gateway = 'mpesa')
    {
        try {
            $worker = resolve(Cashier::class);
            $status = $worker->paymentStatus($ref);
            $_status = resolve(SystemRepository::class)->processCallback($status, $gateway);
            if (!$_status) {
                throw  new TransactionException("Transaction Status is -> " . $status->trx_status);
            }
            return ['success' => true, 'message' => 'Payment was successful', 'ref' => $ref, 'extra' => json_encode($status)];
        } catch (ApiException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}