<?php

namespace Modules\LMS\Services\Payment;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Modules\LMS\Classes\Cart;

class StripeService extends PaymentService
{
    protected $gateway;
    protected static $methodName = 'stripe';


    /**
     * Method makePayment
     *
     * @param $data
     *
     */
    public static function makePayment($data = null)
    {
        try {
            $paymentMethod =  parent::geMethodInfo();
            Stripe::setApiKey($paymentMethod->keys['secret_key']);
            
            // Configure SSL verification for local development
            if (app()->environment('local') || config('app.debug')) {
                Stripe::setVerifySslCerts(false);
            }
            $totalAmount = Cart::totalPrice();
            if (session()->has('type') && session()->get('type') == 'subscription') {
                $totalAmount =  session()->get('subscription_price');
            }
            $amount =  $paymentMethod->conversation_rate ? $totalAmount / $paymentMethod->conversation_rate :  $totalAmount;
            $stripeAmount = $amount * 100;
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => $paymentMethod->currency,
                        'product_data' => [
                            'name' => 'course',
                        ],
                        'unit_amount' => $stripeAmount,
                    ],
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', $paymentMethod->slug),
                'cancel_url' => route('payment.cancel'),
            ]);
            return [
                'status' => 'success',
                'message' => 'Checkout created successfully!',
                'sessionId' => $checkout_session->id,
                'gateway_url' => $checkout_session->url
            ];
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Handle SSL/network connection errors specifically
            return [
                'status' => 'error',
                'message' => 'Network connection failed. This might be due to SSL certificate issues in local development. Error: ' . $e->getMessage(),
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API errors
            return [
                'status' => 'error',
                'message' => 'Stripe API error: ' . $e->getMessage(),
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => 'Checkout creation failed! ' . $th->getMessage(),
            ];
        }
    }
}
