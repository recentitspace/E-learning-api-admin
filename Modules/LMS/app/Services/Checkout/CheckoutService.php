<?php

namespace Modules\LMS\Services\Checkout;

use Modules\LMS\Services\Payment\PaypalService;
use Modules\LMS\Services\Payment\StripeService;
use Modules\LMS\Services\Payment\XenditService;
use Modules\LMS\Services\Payment\PaystackService;
use Modules\LMS\Services\Payment\RazorpayService;
use Modules\LMS\Services\Payment\OfflinePayService;
use Modules\LMS\Services\Payment\WaafiPayService;




class CheckoutService
{
    public static function checkout($request)
    {
        if (!empty($request->payment_method)) {
            return match ($request->payment_method) {
                'stripe' => StripeService::makePayment(),
                'paypal' => PaypalService::makePayment(),
                'xendit' => XenditService::makePayment(),
                'razorpay' => RazorpayService::makePayment(),
                'paystack' => PaystackService::makePayment(),
                'offline' => OfflinePayService::makePayment($request),
                'waafipay' => WaafiPayService::makePayment($request),
                default => [
                    'status' => 'error',
                    'message' => translate('Invalid payment method'),
                ],
            };
        }
        return [
            'status' => 'error',
            'message' => translate('Please select a payment method'),
        ];
    }
}
