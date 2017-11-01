<?php

namespace Ignite\Finance\Library;

use GuzzleHttp\Client;
use Ignite\Finance\Repositories\Jambo;

/**
 * Class JamboPay
 * @package Ignite\Finance\Library
 */
class JamboPay implements Jambo
{
    /**
     * @var Client
     */
    private $client;

    public function _construct()
    {
        $this->client = new Client([
            'timeout' => false,
        ]);
        dd($this);
    }

    public function getMerchantStream()
    {

    }
}