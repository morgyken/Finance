<?php

namespace Ignite\Finance\Library;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Ignite\Finance\Entities\JambopayPayment;
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
     * @var object
     */
    private $token;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 60,
            'allow_redirects' => true,
            'expect' => false,
//            'http_errors' => false,
        ]);
        if (!$this->is_connected()) {
            throw new ApiException('No internet connection');
        }
        $this->token = $this->getToken();
    }

    /**
     * @return bool
     */
    private function is_connected(): bool
    {
        $connected = @fsockopen('www.dervisgroup.com', 80);
        @fclose($connected);
        return (bool)$connected;
    }

    /**
     * Generate access token
     * @return object
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
        $this->validatePayload($data);
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

    /**
     * @param string $endpoint
     * @param array $data
     * @param callable $callback
     * @return mixed
     */
    private function _curl($endpoint, $data, $callback)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->base_url . $endpoint,
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
        return $callback($response, $err);
    }

    public function checkPatientHasWallet(Patients $patient)
    {
        return $this->checkWalletExist($patient->mobile);
    }

    /**
     * @param Patients $patient
     * @param string|null $pin
     * @return mixed
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    public function createWalletForPatient(Patients $patient, $pin = null)
    {
        $data =
            [
                'Stream' => 'wallet',
                'FirstName' => $patient->first_name,
                'MiddleName' => $patient->middle_name,
                'LastName' => $patient->last_name,
                'IDNumber' => $patient->id_no,
                'Email' => $patient->email,
                'PhoneNumber' => $this->formatPhoneNumber($patient->mobile),
                'Pin' => $pin ?? $this->guessPin($patient),
            ];
        $this->validatePayload(array_except($data, ['MiddleName']));
        return $this->createWallet($data);
    }

    /**
     * Format user phone number
     * @param $number
     * @param bool $strip_plus
     * @return string
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    private function formatPhoneNumber($number, $strip_plus = true): string
    {
        $number = preg_replace('/\s+/', '', $number);
        /**
         * Replace with nice phone number
         * @param $needle
         * @param $replacement
         */
        $replace = function ($needle, $replacement) use (&$number) {
            if (starts_with($number, $needle)) {
                $pos = strpos($number, $needle);
                $number = substr_replace($number, $replacement, $pos, strlen($needle));
            }
        };
        $replace('2547', '+2547');
        $replace('07', '+2547');
        $valid_phone = strlen($number) === 13;
        if ($strip_plus) {
            $replace('+254', '254');
            $valid_phone = strlen($number) === 12;
        }
        if (!$valid_phone) {
            throw  new ApiException('Invalid phone number ==> ' . $number);
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

    /**
     * @param Patients $patient
     * @param int $amount
     * @param string $narrative
     * @return mixed
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    public function postBillForPatient(Patients $patient, $amount, $narrative = null)
    {
        if (empty($narrative)) {
            $narrative = 'Patient Billing for ' . m_setting('core.site-name') . ' on ' . Carbon::now()->toDateTimeString();
        }
        $data = [
            'narrative' => $narrative,
            'mobile' => $patient->mobile,
            'amount' => $amount,
        ];
        $this->validatePayload($data);
        $bill = $this->universalBillGenerator((object)$data);
        $mine = null;
        parse_str(request('payload'), $mine);
        $payload = ['selected_items' => json_encode(array_except($mine, '_token'))];
        $bill_info = json_decode($bill, true);
        $attributes = array_merge($bill_info, ['patient_id' => $patient->id], $payload);
        return JambopayPayment::create($attributes);
    }

    /**
     * @param object $data
     * @return mixed
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    private function universalBillGenerator($data)
    {
        $streams = $this->getMerchantStreams();
        $data = [
            'Stream' => 'merchantbill',
            'RevenueStreamID' => $streams->ID,
            'MerchantID' => m_setting('finance.merchant_id', 'Trans'),
            'Narration' => $data->narrative,
            'PhoneNumber' => $this->formatPhoneNumber($data->mobile),
            'Amount' => $data->amount,
        ];
        $this->validatePayload($data);
        return $this->_curl('api/payments/Post', $data, function ($response, $error) {
            if ($error) {
                throw new ApiException($error);
            }
            return $response;
        });
    }

    private function getMerchantStreams()
    {
        $data = [
            'Stream' => 'merchantbill',
            'MerchantID' => m_setting('finance.merchant_id', 'Trans'),
        ];
        $this->validatePayload($data);
        $request = \Curl::to($this->base_url . 'api/payments/GetMerchantStreams')
            ->withHeaders([
                'app_key: ' . $this->app_key,
                'authorization: ' . $this->token->token_type . ' ' . $this->token->access_token,
            ])
            ->withData($data)
            ->withContentType('application/x-www-form-urlencoded')
            ->returnResponseObject()
            ->get();
        try {
            $object = json_decode($request->content);
            return collect($object)->first();
        } catch (\Exception $e) {
            throw  new ApiException($e->getMessage());
        }
    }

    /**
     * @param Patients $patient
     * @param string $bill_number
     * @return mixed
     * @throws \Ignite\Finance\Library\Payments\Core\Exceptions\ApiException
     */
    public function getBillStatus(Patients $patient, $bill_number)
    {
        $data = [
            'Stream' => 'merchantbill',
            'PhoneNumber' => $this->formatPhoneNumber($patient->mobile),
            'BillNumber' => $bill_number,
            'Year' => Carbon::now()->year,
            'Month' => Carbon::now()->month,
        ];
        $this->validatePayload($data);
        $p = \Curl::to($this->base_url . 'api/payments/GetBill')
            ->withHeaders([
                'app_key: ' . $this->app_key,
                'authorization: ' . $this->token->token_type . ' ' . $this->token->access_token,
            ])
            ->withData($data)
            ->withContentType('application/x-www-form-urlencoded')->returnResponseObject()->get();
        try {
            return json_decode($p->content);
            return (bool)$r->Exists;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $arrays
     * @throws ApiException
     */
    private function validatePayload($arrays)
    {
        foreach ($arrays as $key => $value) {
            if (empty($value)) {
                throw new ApiException('Missing value for required field ' . $key);
            }
        }
    }

    /**
     * @param int|null $patient_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function pendingBills($patient_id = null)
    {
        $query = JambopayPayment::where('created_at', '>=', Carbon::yesterday())
            ->whereComplete(false);
        if ($patient_id) {
            $query = $query->wherePatientId($patient_id);
        }
        return $query->get();
    }

    /**
     * @return mixed
     */
    public function checkPayments()
    {
        $pending = $this->pendingBills();
        dd($pending);
    }
}