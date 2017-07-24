<?php

namespace Ignite\Finance\Library\Mpesa;


use Carbon\Carbon;
use DOMDocument;
use GuzzleHttp\Client;
use Ignite\Finance\Library\Mpesa\Exceptions\TransactionException;
use Ignite\Finance\Library\Mpesa\Repository\MpesaRepository;

/**
 * Class Transactor
 * @package Ignite\Finance\Library\Mpesa
 */
class Transactor
{
    /**
     * @var string
     */
    protected $password;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var int
     */
    protected $referenceId;

    /**
     * @var int
     */
    protected $amount;

    /**
     * The Mobile Subscriber number to be billed.
     * Must be in format 2547XXXXXXXX.
     *
     * @var int
     */
    protected $number;

    /**
     * The keys and data to fill in the request body.
     *
     * @var array
     */
    protected $keys;

    /**
     * The request to be sent to the endpoint
     *
     * @var string
     */
    protected $request;

    /**
     * The generated transaction number by the TransactionGenerator implementer.
     *
     * @var string
     */
    protected $transactionNumber;

    /**
     * The Guzzle Client used to make the request to the endpoint.
     *
     * @var Client
     */
    private $client;

    /**
     * The M-Pesa configuration repository.
     *
     * @var MpesaRepository
     */
    private $repository;

    /**
     * Transactor constructor.
     *
     * @param MpesaRepository $repository
     */
    public function __construct(MpesaRepository $repository)
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 60,
            'allow_redirects' => false,
            'expect' => false,
        ]);
        $this->repository = $repository;
    }

    /**
     * Process the transaction request.
     *
     * @param $amount
     * @param $number
     * @param $referenceId
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function process($amount, $number, $referenceId)
    {
        $this->amount = $amount;
        $this->number = $number;
        $this->referenceId = $referenceId;
        $this->initialize();
        return $this->handle();
    }

    /**
     * Initialize the transaction.
     */
    protected function initialize()
    {
        $this->setTimestamp();
        $this->generatePassword();
        $this->setupKeys();
    }

    /**
     * Validate and execute the transaction.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function handle()
    {
        $this->validateKeys();
        $this->generateRequest('request.xml');
        $this->send();
        $this->generateRequest('process.xml');

        return $this->send();
    }

    /**
     * Set the transaction timestamp.
     */
    private function setTimestamp()
    {
        $this->timestamp = Carbon::now()->format('YmdHis');
        return $this->timestamp;
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
        $this->repository->paybillNumber = $payBillNumber;
        $this->repository->passkey = $payBillPassKey;
        return $this;
    }

    /**
     * Generate the password for the transaction.
     */
    private function generatePassword()
    {
        if ($this->repository->demo) {
            $this->password = 'ZmRmZDYwYzIzZDQxZDc5ODYwMTIzYjUxNzNkZDMwMDRjNGRkZTY2ZDQ3ZTI0YjVjODc4ZTExNTNjMDA1YTcwNw==';
            return $this->password;
        }

        $passwordSource = $this->repository->paybillNumber . $this->repository->passkey . $this->timestamp;
        $this->password = base64_encode(hash("sha256", $passwordSource));

        return $this->password;
    }

    /**
     * Map the document fields with the transaction details.
     */
    protected function setupKeys()
    {
        $this->keys = [
            'E_PAYBILL' => $this->repository->paybillNumber,
            'E_PASSWORD' => $this->password,
            'E_TIMESTAMP' => $this->timestamp,
            'E_TRANS_ID' => $this->getTransactionNumber(),
            'E_REF_ID' => $this->referenceId,
            'E_AMOUNT' => $this->amount,
            'E_NUMBER' => $this->number,
            'E_CALL_URL' => $this->repository->callbackUrl,
            'E_CALL_METHOD' => $this->repository->callbackMethod,
        ];
    }

    /**
     * Get the transaction number      *
     * @return string
     */
    private function getTransactionNumber()
    {
        $this->transactionNumber = $this->generateTransactionNumber();
        return $this->transactionNumber;
    }

    /**
     * Validate the required fields.
     */
    private function validateKeys()
    {
        Validator::validate($this->keys);
    }

    /**
     * Fetch the XML document and include the transaction data.
     *
     * @param string $document
     */
    private function generateRequest($document)
    {
        $this->request = file_get_contents(__DIR__ . '/Request/' . $document);
        foreach ($this->keys as $key => $value) {
            $this->request = str_replace($key, $value, $this->request);
        }
    }

    /**
     * Execute the request.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function send()
    {
        $response = $this->client->request('POST', $this->repository->endpoint, [
            'body' => $this->request
        ]);
        $this->validateResponse($response);
        return $response;
    }

    /**
     * Validate the response is a success, throw error if not.
     *
     * @param Response $response
     *
     * @throws TransactionException
     */
    private function validateResponse($response)
    {
        $message = $response->getBody()->getContents();
        $response->getBody()->rewind();
        $doc = new DOMDocument();
        $doc->loadXML($message);
        $responseCode = $doc->getElementsByTagName('RETURN_CODE')->item(0)->nodeValue;
        if ($responseCode != '00') {
            $responseDescription = $doc
                ->getElementsByTagName('DESCRIPTION')
                ->item(0)
                ->nodeValue;

            throw new TransactionException('Failure - ' . $responseCode . ' : ' . $responseDescription);
        }
    }

    /**
     * @return string
     */
    private function generateTransactionNumber()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 17; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}