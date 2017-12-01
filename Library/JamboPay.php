<?php

namespace Ignite\Finance\Library;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Finance\Entities\Copay;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Finance\Entities\JambopayPayment;
use Ignite\Finance\Library\Payments\Core\Exceptions\ApiException;
use Ignite\Finance\Repositories\EvaluationRepository;
use Ignite\Finance\Repositories\Jambo;
use Ignite\Reception\Entities\Patients;
use Ixudra\Curl\Facades\Curl;

/**
 * Class JamboPay
 * @property object $old_request
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

    /**
     * JamboPay constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 60,
            'allow_redirects' => true,
            'expect' => false,
//            'http_errors' => false,
        ]);
    }

    /**
     * @throws ApiException
     */
    private function setToken()
    {
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
     * @throws ApiException
     */
    private function checkWalletExist($number)
    {
        $data = [
            'Stream' => 'wallet',
            'PhoneNumber' => $this->formatPhoneNumber($number),
        ];
        $this->validatePayload($data);
        $this->setToken();
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
        $this->setToken();
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
     * @throws ApiException
     */
    private function _curl($endpoint, $data, $callback)
    {
        $this->setToken();
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

    /**
     * @return mixed
     * @throws ApiException
     */
    private function getMerchantStreams()
    {
        $data = [
            'Stream' => 'merchantbill',
            'MerchantID' => m_setting('finance.merchant_id', 'Trans'),
        ];
        $this->validatePayload($data);
        $this->setToken();
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
        $this->setToken();
        $p = \Curl::to($this->base_url . 'api/payments/GetBill')
            ->withHeaders([
                'app_key: ' . $this->app_key,
                'authorization: ' . $this->token->token_type . ' ' . $this->token->access_token,
            ])
            ->withData($data)
            ->withContentType('application/x-www-form-urlencoded')->returnResponseObject()->get();
        try {
            return json_decode($p->content);
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
     * @return JambopayPayment[]
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
        if (m_setting('finance.enable_jambo_pay')) {
            $pending = $this->pendingBills();
            foreach ($pending as $bill) {
                $patient = Patients::find($bill->patient_id);
                $status = $this->getBillStatus($patient, $bill->BillNumber);
                if (!empty($status->PaymentStatus)) {
                    $this->processPayment($bill, $status);
                }
            }
            reload_payments();
        }
    }

    /**
     * @param JambopayPayment $bill
     * @param $status
     * @return int
     */
    private function processPayment($bill, $status)
    {
        $this->old_request = json_decode($bill->selected_items);
        \DB::beginTransaction();
        $payment = new EvaluationPayments;
        $payment->patient = $bill->patient_id;
        $payment->receipt = generate_receipt_no();
        $payment->user = $this->old_request->user_id;
        $payment->save();
        $payment->amount = $this->saveJpRecord($payment, $status, $bill);
        $payment->save();
        $this->payment_details($payment);
        $this->pay_id = $payment->id;
        \DB::commit();
        return $this->pay_id;
    }

    private function payment_details($payment)
    {
        $stack = function ($needle = null) {
            $stack = [];
            if (empty($needle)) {
                $needle = 'item';
            }
            foreach ($this->old_request as $key => $one) {
                if (starts_with($key, $needle)) {
                    $stack[] = substr($key, strlen($needle));
                }
            }
            return $stack;
        };
        $isPaymentFor = function ($item, $is): bool {
            if ($this->old_request->{'type' . $item}) {
                return ($this->old_request->{'type' . $item} === $is);
            }
            return false;
        };
        foreach ($stack() as $item) {
            if ($isPaymentFor($item, 'pharmacy')) {
                $this->updatePrescriptions($item, $payment);
//                $this->drug_payment_details($request, $item, $payment);
            } elseif ($isPaymentFor($item, 'copay')) {
                $this->copayment($item, $payment);
            } else {
                $this->investigation_payment_details($item, $payment);
            }
        }
    }

    /**
     * @param $item
     * @param $payment
     * @return bool
     */

    private function investigation_payment_details($item, $payment)
    {
        $visit = 'visits' . $item;
        $investigation = Investigations::find($item);
        $detail = new EvaluationPaymentsDetails;
        $detail->price = $investigation->price;
        $detail->investigation = $item;
        $detail->visit = $this->old_request->$visit;
        $detail->payment = $payment->id;
        $detail->cost = $investigation->procedures->price;
        return $detail->save();
    }

    /**
     * @param $item
     * @param $payment
     * @return bool
     */
    private function copayment($item, $payment)
    {
        $copay = Copay::find($item);
        $copay->payment_id = $payment->id;
        return $copay->save();
    }

    /**
     * @param $item
     * @param EvaluationPayments $payment
     * @return bool
     */
    private function updatePrescriptions($item, $payment)
    {
        $p = Prescriptions::find($this->old_request->{'item' . $item});
        $p->payment()->update(['paid' => true]);
        $visit = 'visits' . $item;
        $detail = new EvaluationPaymentsDetails;
        $detail->price = $p->payment->total;
        $detail->prescription_id = $p->id;
        $detail->visit = $this->old_request->$visit;
        $detail->payment = $payment->id;
        $detail->cost = $p->payment->total;
        return $detail->save();
    }

    /**
     * @param $payment
     * @param $status
     * @param JambopayPayment $jp
     * @return int
     */
    public function saveJpRecord($payment, $status, $jp)
    {
        $jp->payment_id = $payment->id;
        $jp->PaymentStatus = $status->PaymentStatus;
        $jp->PaymentStatusName = $status->PaymentStatusName;
        $jp->processed = true;
        $jp->complete = true;
        $jp->save();
        return $status->Amount;
    }
}