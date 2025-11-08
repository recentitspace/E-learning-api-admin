<?php

namespace Modules\LMS\Services\Payment;

use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Modules\LMS\Classes\Cart;

class RazorpayService extends PaymentService
{
    protected $gateway;
    protected static $methodName = 'razorpay';

    public static function makePayment($data = null)
    {
        try {

            $backendSetting = get_theme_option(key: 'backend_general') ?? null;
            $logo_name = get_theme_option(key: 'logo', parent_key: 'theme_logo') ?? null;
            $mainLogo =  $logo_name && fileExists('lms/theme-options', $logo_name) == true
                ? asset("storage/lms/theme-options/{$logo_name}")
                : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
            $logo = $defaultLogo ?? $mainLogo;

            $user = authCheck();

            $paymentMethod =  parent::geMethodInfo();
            $apiKey = $paymentMethod->keys['key_id'] ?? '';
            $secretKey = $paymentMethod->keys['secret_key'] ?? '';
            $api = new Api($apiKey,  $secretKey);
            $receiptId = Str::random(20);
            $totalAmount = Cart::totalPrice();

            if (session()->has('type') && session()->get('type') == 'subscription') {
                $totalAmount =  session()->get('subscription_price');
            }


            $amount =  $paymentMethod->conversation_rate ? $totalAmount / $paymentMethod->conversation_rate :  $totalAmount;
            $order = $api->order->create([
                'receipt' => $receiptId,
                'amount' => $amount * 100,
                'currency' => $paymentMethod->currency,
            ]);

            $response = [
                'orderId' => $order['id'],
                'razorpayId' => $apiKey,
                'amount' => $amount,
                'name' => $user?->userable?->first_name ?? '',
                'currency' =>  $paymentMethod->currency,
                'email' => $user->email,
                'contactNumber' => $user?->userable?->phone ?? '',
                'address' =>  $user?->userable?->address ?? '',
                'description' =>  $backendSetting['app_name'] ?? '',
                'method' => 'razorpay',
                'image' =>  $logo,
                'app_name' => $backendSetting['app_name'] ?? ''
            ];
            return $response;
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
    }
}
