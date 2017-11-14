<?php

namespace Ignite\Finance\Library;

use GuzzleHttp\Client;
use Ignite\Finance\Library\Payments\Core\Exceptions\ApiException;
use Ignite\Finance\Repositories\Jambo;
use Ignite\Reception\Entities\Patients;
use Ixudra\Curl\Facades\Curl;

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
    private $base_url = 'http://197.254.58.150/JamboPayServices/';
    /**
     * @var string
     */
    private $app_key = 'BBD14E65-5B05-E611-9411-7427EA2F7F59';
    /**
     * @var string
     */
    private $token;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 60,
            'allow_redirects' => true,
            'expect' => false,
            'decode_content' => false,
//            'http_errors' => false,
        ]);
        $this->token = $this->getToken();
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
     * @return bool
     */
    private function checkWalletExist($number)
    {
        $data = [
            'Stream' => 'wallet',
            'PhoneNumber' => $this->formatPhoneNumber($number),
        ];
        $p = \Curl::to($this->base_url . 'api/payments/GetWalletExists')
            ->withHeaders([
                'app_key: ' . $this->app_key,
                'authorization: ' . $this->token->token_type . ' ' . $this->token->access_token,
            ])
            ->withData($data)
            ->withContentType('application/x-www-form-urlencoded')->returnResponseObject()->get();
        try {
            $r = json_decode($p->content);
            return (bool)$r->Exists;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ApiException
     */
    private function createWallet($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->base_url . 'api/payments/PostWalletRegister',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data, '', '&'),
            CURLOPT_HTTPHEADER => [
                'app_key: ' . $this->app_key,
                'authorization: ' . $this->token->token_type . ' ' . $this->token->access_token,
                'cache-control: no-cache',
                'content-type: application/x-www-form-urlencoded',
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw  new ApiException($err);
        }
        return json_decode($response);
    }

    public function checkPatientHasWallet(Patients $patient)
    {
        return $this->checkWalletExist($patient->mobile);
    }

    /**
     * @param Patients $patient
     * @return mixed
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    public function createWalletForPatient(Patients $patient)
    {
        $payload =
            [
                'Stream' => 'wallet',
                'FirstName' => $patient->first_name,
                'MiddleName' => $patient->middle_name,
                'LastName' => $patient->last_name,
                'IDNumber' => $patient->id_no,
                'Email' => $patient->email,
                'PhoneNumber' => $this->formatPhoneNumber($patient->mobile),
                'Pin' => $this->guessPin($patient),
            ];
        return $this->createWallet($payload);
    }

    /**
     * @param $number
     * @return mixed
     */
    private function formatPhoneNumber($number)
    {
        if (strlen($number) === 10) {
            $needle = '07';
            if (starts_with($number, $needle)) {
                $pos = strpos($number, $needle);
                $number = substr_replace($number, '2547', $pos, strlen($needle));
            }
        }
        return $number;

    }

    /**
     * @param Patients $patients
     * @return bool|string
     */
    private function guessPin(Patients $patients)
    {
        return substr($patients->mobile, -4);
    }
}