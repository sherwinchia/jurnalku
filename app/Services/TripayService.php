<?php

namespace App\Services;

use App\Models\User;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TripayService
{
    const TRIPAY_URL = 'https://tripay.co.id/api-sandbox/';

    private $apiKey;
    private $privateKey;
    private $merchantCode;

    public function __construct()
    {
        $this->apiKey       = config('tripay.api_key');
        $this->privateKey   = config('tripay.private_key');
        $this->merchantCode = config('tripay.merchant_code');
    }

    public function getPaymentChannels()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => self::TRIPAY_URL . 'merchant/payment-channel?',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $this->apiKey],
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
        $payload = ['reference'  => $reference];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => self::TRIPAY_URL . 'transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $this->apiKey],
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

    public function requestTransaction(User $user, Package $package, string $method = null, float $amount)
    {
        $merchantRef = get_unique_merchant_ref();

        if ($amount == 0) {
            $data = new \stdClass();
            $data->merchant_ref = $merchantRef;
            $data->amount = 0;

            $response = new \stdClass();
            $response->success = true;
            $response->message = "";
            $response->data = $data;
            return $response;
        }

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
            'signature'    => hash_hmac('sha256', $this->merchantCode . $merchantRef . $amount, $this->privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => self::TRIPAY_URL . 'transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $this->apiKey],
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

    public function handleCallback(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return 'Invalid signature';
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return 'Invalid callback event, no action was taken';
        }

        $data = json_decode($json);
        $merchantRef = $data->merchant_ref;

        $transaction = Transaction::where('merchant_ref', $merchantRef)
            ->where('status', 'pending')
            ->firstOrFail();

        if (!$transaction) {
            return 'Transaction not found or current status is not pending';
        }

        if ((int) $data->total_amount !== (int) $transaction->net_total) {
            return 'Invalid amount';
        }

        switch ($data->status) {
            case 'PAID':
                $transaction->update(['status' => 'success']);
                $user = $transaction->user;
                $subscription = $user->subscription;

                $subscription->update([
                    'expired_at' => $subscription->addDays($transaction->package->duration),
                    'type' => 'paid',
                    'package_id' => $transaction->package_id,
                ]);
                return true;

            case 'EXPIRED':
                $transaction->update(['status' => 'expired']);
                return true;

            case 'FAILED':
                $transaction->update(['status' => 'fail']);
                return true;

            default:
                return 'Unrecognized payment status';
        }
    }

    public function updateTransaction($merchantRef)
    {
        $transaction = Transaction::where('merchant_ref', $merchantRef)
            ->where('status', 'pending')
            ->firstOrFail();

        $transaction->update(['status' => 'success']);
        $user = $transaction->user;
        $subscription = $user->subscription;

        foreach ($transaction->items as $transactionItem) {
            if ($transactionItem->package->type == "duration") {
                $subscription->update([
                    'expired_at' => $subscription->expired_at->addDays($transactionItem->package->value),
                    'type' => 'paid',
                    'package_id' => $transaction->package_id,
                ]);
            } elseif ($transactionItem->package->type == "portfolio") {
                $subscription->update([
                    'max_portfolio' => $subscription->max_portfolio + $transactionItem->package->value,
                ]);
            }
        }
    }
}
