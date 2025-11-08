<?php

namespace Modules\LMS\Services\Payment;

use Modules\LMS\Classes\Cart;

class PaypalService extends PaymentService
{
    protected $gateway;
    protected static $methodName = 'paypal';

    /**
     * Method makePayment
     *
     */
    public static function makePayment($data = null)
    {
        $paymentMethod =  parent::geMethodInfo();

        $totalAmount = Cart::totalPrice();
        if (session()->has('type') && session()->get('type') == 'subscription') {
            $totalAmount =  session()->get('subscription_price');
        }
        $amount =  $paymentMethod->conversation_rate ? $totalAmount / $paymentMethod->conversation_rate :  $totalAmount;
        return [
            'amount' => $amount,
            'currency' =>  $paymentMethod->currency,
            'success_url' => route('payment.success', $paymentMethod->slug),
            'sandbox_client_id' =>  $paymentMethod->keys['sandbox_client_id'],
            'production_client_id' =>  $paymentMethod->keys['production_client_id'],
            'enabled_test_mode' => $paymentMethod->enabled_test_mode,
            'payment_mode' => $paymentMethod->enabled_test_mode ? 'production' : 'sandbox'
        ];
    }
}
