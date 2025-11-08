<?php

namespace Modules\LMS\Services\Payment;

use Illuminate\Support\Str;
use Modules\LMS\Classes\Cart;
use Unicodeveloper\Paystack\Facades\Paystack;



class PaystackService extends PaymentService
{
    protected $gateway;

    protected static $methodName = 'paystack';

    public static function makePayment($data = null)
    {
        $paymentMethod =  parent::geMethodInfo();
        try {
            $user = authCheck();

            $totalAmount = Cart::totalPrice();

            if (session()->has('type') && session()->get('type') == 'subscription') {
                $totalAmount =  session()->get('subscription_price');
            }

            $amount =  $paymentMethod->conversation_rate ? $totalAmount / $paymentMethod->conversation_rate :  $totalAmount;
            $data = [
                "amount" =>  round($amount * 100, 2),
                'callback_url' =>  route('payment.success', 'paystack'),
                'reference' => random_string(15),
                "email" =>   $user->email,
                "currency" =>  $paymentMethod->currency,
                "orderID" => Str::random(5),
            ];
            $response = Paystack::getAuthorizationUrl($data);
            return  [
                'status' => 'success',
                'gateway_url' => $response->url
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'message' => 'Payment failed! ' . $exception->getMessage(),
            ];
        }
    }
}
