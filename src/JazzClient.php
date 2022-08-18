<?php


namespace Brikmas\Jazzcash;

use Brikmas\Jazzcash\Contracts\RestServiceContract;
use Brikmas\Jazzcash\Entities\PaymentReq;
use Brikmas\Jazzcash\Entities\StatusInquiryReq;
use Brikmas\Jazzcash\Entities\VoucherReq;

/**
 * Class JazzClient
 *
 * REST service handler
 *
 * @package Brikmas\Gateway\Jazzcash
 */
class JazzClient
{
    const VERSION = 0.1;

    private $apiBaseUrl;
    private $sharedSecret;
    private $merchantId;
    private $password;

    /**
     * Client constructor.
     *
     * @param array $config
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        if (!empty($config) && !is_array($config)) {
            throw new \Exception('$config must be an an array');
        }

        $this->apiBaseUrl   = $config['apiBaseUrl'];
        $this->merchantId   = $config['merchantId'];
        $this->password     = $config['password'];
        $this->sharedSecret = $config['salt'];

        if (empty($this->apiBaseUrl)) {
            throw new \Exception('Api base url is required');
        }

        if (empty($this->merchantId)) {
            throw new \Exception('Api merchant id is required');
        }

        if (empty($this->password)) {
            throw new \Exception('Api password is required');
        }

        if (empty($this->sharedSecret)) {
            throw new \Exception('Api salt/shared secret key is required');
        }
    }

    /**
     * @param PaymentReq $payload
     * @return object
     * @throws \Exception
     */
    public function callMobileAccountService(PaymentReq $payload)
    {
        $this->setServiceUrl('2.0/Purchase/DoMWalletTransaction');

        return $this->callService($payload);
    }

    /**
     * @param VoucherReq $payload
     * @return object
     * @throws \Exception
     */
    public function callVoucherService(VoucherReq $payload)
    {
        $this->setServiceUrl('Payment/DoTransaction');

        return $this->callService($payload);
    }

    /**
     * @param StatusInquiryReq $payload
     * @return object
     * @throws \Exception
     */
    public function callStatusInquiryService(StatusInquiryReq $payload)
    {
        $this->setServiceUrl('PaymentInquiry/Inquire');

        return $this->callService($payload);
    }

    /**
     * @param $uri
     */
    private function setServiceUrl($uri)
    {
        $this->apiBaseUrl = rtrim($this->apiBaseUrl, '/');
        $this->apiBaseUrl .= '/ApplicationAPI/API/' . $uri;
    }

    /**
     * @param RestServiceContract $payload
     * @return object
     * @throws \Exception
     */
    private function callService(RestServiceContract $payload)
    {
        $payload->setMerchantId($this->merchantId);
        $payload->setPassword($this->password);
        $payload->setSecureHash($this->createHash($payload));

        $cURLConnection = curl_init($this->apiBaseUrl);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($cURLConnection, CURLOPT_POST, true);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_FAILONERROR, false);

        $apiResponse = curl_exec($cURLConnection);
        $errorMessage = '';

        if (curl_errno($cURLConnection)) {
            $errorMessage = 'Fatal Error: ' . curl_error($cURLConnection);
        }

        curl_close($cURLConnection);

        if (! empty($errorMessage)) {
            throw new \Exception($errorMessage);
        }

        return json_decode($apiResponse);
    }

    /**
     * Create hash
     *
     * @param $payload
     * @return string
     */
    private function createHash($payload)
    {
        $salt = $this->sharedSecret;
        $sortedResponseArray = array();

        if (!empty($payload)) {
            foreach ($payload as $key => $val) {
                $sortedResponseArray[$key] = $val;
            }
        }

        ksort($sortedResponseArray);
        $hashString = $salt;

        foreach ($sortedResponseArray as $key => $val) {
            if (!empty($val) && ($val != 'null' || $val != null)) {
                $hashString .= '&' . $val;
            }
        }

        return strtoupper(hash_hmac('sha256', $hashString, $salt));
    }
}