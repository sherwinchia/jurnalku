<?php

namespace App\Services;

use App\Models\User;
use App\Models\Package;

class TripayService
{
    const TRIPAY_URL = 'https://tripay.co.id/api-sandbox/';

    public function getPaymentChannels()
    {
        $apiKey = config('tripay.api_key');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => self::TRIPAY_URL . 'merchant/payment-channel?',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        $error = curl_error($curl);

        curl_close($curl);

        if (!empty($error)) {
            throw new \Exception($error);
        }
        return $response;
    }

    public function getTransactionDetail($reference)
    {
        $apiKey = config('tripay.api_key');

        $payload = ['reference'  => $reference];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => self::TRIPAY_URL . 'transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
        ]);

        $response = curl_exec($curl);
        $response = json_decode($response);
        $error = curl_error($curl);

        if (!empty($error)) {
            throw new \Exception($error);
        }

        return $response;
    }

    public function requestTransaction(User $user, Package $package, string $method, float $amount)
    {
        $apiKey       = config('tripay.api_key');
        $privateKey   = config('tripay.private_key');
        $merchantCode = config('tripay.merchant_code');
        $merchantRef = get_unique_merchant_ref();

        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone_number,
            'order_items'    => [
                [
                    'name'        => $package->name,
                    'price'       => $amount,
                    'quantity'    => 1,
                ]
            ],
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => self::TRIPAY_URL . 'transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data)
        ]);

        $response = curl_exec($curl);

        $response = json_decode($response);

        $error = curl_error($curl);

        curl_close($curl);

        if (!empty($error)) {
            throw new \Exception($error);
        }

        return $response;
    }
}
