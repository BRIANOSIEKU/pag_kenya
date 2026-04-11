<?php

namespace App\Services;

use GuzzleHttp\Client;

class MpesaService
{
    protected $client;
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortCode;
    protected $passkey;
    protected $environment;

    public function __construct()
    {
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->shortCode = env('MPESA_SHORTCODE'); // Paybill or Till
        $this->passkey = env('MPESA_PASSKEY');
        $this->environment = env('MPESA_ENV', 'sandbox'); // sandbox or live

        $this->client = new Client();
    }

    // Get access token
    public function getAccessToken()
    {
        $url = $this->environment === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' 
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = $this->client->request('GET', $url, [
            'auth' => [$this->consumerKey, $this->consumerSecret]
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'] ?? null;
    }

    // Initiate STK Push
    public function stkPush($phone, $amount, $accountReference, $transactionDesc)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            throw new \Exception("Unable to get access token");
        }

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortCode.$this->passkey.$timestamp);

        $url = $this->environment === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
            : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $response = $this->client->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                "BusinessShortCode" => $this->shortCode,
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $phone, // customer phone
                "PartyB" => $this->shortCode,
                "PhoneNumber" => $phone,
                "CallBackURL" => route('mpesa.callback'), // define route
                "AccountReference" => $accountReference,
                "TransactionDesc" => $transactionDesc
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}