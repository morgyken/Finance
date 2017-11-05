<?php

namespace Ignite\Finance\Library;

use GuzzleHttp\Client;
use Ignite\Finance\Library\Payments\Core\Exceptions\ApiException;
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
    /**
     * @var string
     */
//    private $base_url = 'http://192.168.11.22/';
    private $base_url = 'http://197.254.58.150/jambopayservices/';
    /**
     * @var string
     */
    private $app_key = 'BBD14E65-5B05-E611-9411-7427EA2F7F59';

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 60,
            'allow_redirects' => false,
            'expect' => false,
//            'http_errors' => false,
        ]);
    }

    /**
     * Generate access token
     * @return string
     * @throws ApiException
     */
    private function getToken()
    {
        $response = $this->client->post($this->base_url . 'token', [
            'form_params' => [
                'grant_type' => 'agency',
                'username' => 'teller1.branch1@agency.com',
                'password' => 'p@ssw0rd'
            ]
        ]);
        $responseCode = $response->getStatusCode();
        $result = json_decode($response->getBody()->getContents());
        if ($responseCode === 200) {
            return $result;
        }
        throw new ApiException($result->error . ' ---- ' . $result->error_description);
    }

    /**
     * @param string $number
     * @return mixed
     */
    public function checkWalletExist($number)
    {

    }

    /**
     * @return mixed
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    public function createWallet()
    {
        $token = $this->getToken();
        $response = $this->client->post($this->base_url . '​api/payments/PostWalletRegister', [
            'headers' => [
                'Authorization' => $token->token_type . $token->access_token,
                'App_key' => 'BBD14E65-5B05-E611-9411-7427EA2F7F59'
            ],
            'debug' => true,
            'form_params' => [
                'Stream' => 'wallet',
                'FirstName' => 'Millicent',
                'MiddleName' => 'Kagwiria',
                'LastName' => 'Barasa',
                'IDNumber' => 30914567,
                'Email' => 'myliet87@mail.com',
                'Phone' => '0716482013',
                'Pin' => 1256
            ]
        ]);
        dd($response);
    }
}