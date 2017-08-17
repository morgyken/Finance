<?php

namespace Ignite\Finance\Library\Payments\Mpesa;

use Ignite\Finance\Library\Payments\Core\Exceptions\InvalidRequestException;
use InvalidArgumentException;

/**
 * Class Cashier
 * @package Dervis\Library\Banker\Mpesa
 */
class Cashier
{
    /**
     * The amount to be deducted.
     *
     * @var int
     */
    protected $amount;

    /**
     * The Mobile Subscriber Number.
     *
     * @var int
     */
    protected $number;

    /**
     * The product reference identifier.
     *
     * @var int
     */
    protected $referenceId;
    /**
     * The transaction handler.
     *
     * @var Transactor
     */
    private $transactor;

    /**
     * Cashier constructor.
     *
     * @param Transactor $transactor
     */
    public function __construct(Transactor $transactor)
    {
        $this->transactor = $transactor;
    }

    /**
     * Override the config pay bill number and pass key.
     *
     * @param $payBillNumber
     * @param $payBillPassKey
     *
     * @return $this
     */
    public function setPayBill($payBillNumber, $payBillPassKey)
    {
        $this->transactor->setPayBill($payBillNumber, $payBillPassKey);

        return $this;
    }


    /**
     * Set the request amount to be deducted.
     *
     * @param int $amount
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function request($amount)
    {
        if (!is_numeric($amount)) {
            throw new InvalidArgumentException('The amount must be numeric');
        }

        $this->amount = $amount;

        return $this;
    }

    public function paymentStatus($ref)
    {
        return $this->transactor->getStatus($ref);
    }

    private function formatPhoneNumber(&$number)
    {
        if (strlen($number) === 10) {
            $needle = '07';
            if (starts_with($number, $needle)) {
                $pos = strpos($number, $needle);
                $number = substr_replace($number, '2547', $pos, strlen($needle));
            }
        }

    }

    /**
     * Set the Mobile Subscriber Number to deduct the amount from.
     * Must be in format 2547XXXXXXXX.
     *
     * @param string $number
     * @return $this
     * @throws InvalidRequestException
     */
    public function from($number)
    {
        $number = formatPhoneNumber($number,true);
        if (!starts_with($number, '2547')) {
            throw new InvalidRequestException('The subscriber number must start with 2547');
        }

        $this->number = $number;

        return $this;
    }

    /**
     * Set the product reference number to bill the account.
     *
     * @param int $referenceId
     *
     * @return $this
     */
    public function usingReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * Initiate the transaction
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function transact()
    {
        return $this->transactor->process($this->amount, $this->number, $this->referenceId);
    }
}
