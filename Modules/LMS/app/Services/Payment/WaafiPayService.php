<?php

namespace Modules\LMS\Services\Payment;

use Modules\LMS\Classes\Cart;
use Illuminate\Support\Facades\Http;

class WaafiPayService extends PaymentService
{
    protected $gateway;
    protected static $methodName = 'waafipay';

    /**
     * Initiate WaafiPay payment
     */
    public static function makePayment($data = null)
    {
        $paymentMethod = parent::geMethodInfo();

        // Handle cart total with fallback
        try {
            $totalAmount = Cart::totalPrice();
            if (session()->has('type') && session()->get('type') == 'subscription') {
                $totalAmount = session()->get('subscription_price');
            }
        } catch (\Exception $e) {
            // Fallback if cart/session is not available
            $totalAmount = $data['amount'] ?? 100.00; // Default test amount
        }

        // Ensure we have a valid amount
        if (!$totalAmount || $totalAmount <= 0) {
            $totalAmount = 100.00; // Default test amount
        }

        $amount = $paymentMethod->conversation_rate ? $totalAmount / $paymentMethod->conversation_rate : $totalAmount;

        // Get credentials from DB keys
        $keys = $paymentMethod->keys ?? [];
        $sandbox = ($paymentMethod->enabled_test_mode ?? 0) == 0;
        $endpoint = $sandbox ? 'http://sandbox.waafipay.net/asm' : 'https://api.waafipay.com/asm';

        // Prepare payload as per WaafiPay docs
        $referenceId = uniqid('waafi_', true);
        $payload = [
            'serviceName' => 'API_PURCHASE',
            'channelName' => 'WEB',
            'serviceParams' => [
                'merchantUid' => $keys['merchant_uid'] ?? '',
                'apiUserId' => $keys['api_user_id'] ?? '',
                'apiKey' => $keys['api_key'] ?? '',
                'paymentMethod' => $keys['payment_method'] ?? 'MWALLET_ACCOUNT',
                'amount' => number_format($amount, 2, '.', ''),
                'currency' => $paymentMethod->currency ?? 'USD',
                'referenceId' => $referenceId,
                'description' => $data['description'] ?? 'Course Payment',
            ]
        ];

        try {
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for sandbox testing
                'timeout' => 30,
            ])->post($endpoint, $payload);
            $result = $response->json();
        } catch (\Exception $e) {
            $result = [
                'responseCode' => 'error',
                'responseMsg' => 'Failed to connect to WaafiPay: ' . $e->getMessage()
            ];
        }

        return [
            'status' => ($result['responseCode'] ?? '') === '2001' ? 'success' : 'error',
            'amount' => $amount,
            'currency' => $paymentMethod->currency,
            'endpoint' => $endpoint,
            'reference_id' => $referenceId,
            'payload' => $payload,
            'waafipay_response' => $result,
            'enabled_test_mode' => $paymentMethod->enabled_test_mode,
            'payment_mode' => $sandbox ? 'sandbox' : 'production',
            'message' => $result['responseMsg'] ?? 'Unable to initiate WaafiPay payment',
        ];
    }
} 