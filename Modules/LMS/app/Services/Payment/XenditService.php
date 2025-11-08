<?php

namespace Modules\LMS\Services\Payment;

use Xendit\Configuration;
use Modules\LMS\Classes\Cart;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;


class XenditService extends PaymentService
{
    protected $gateway;

    protected static $methodName = 'xendit';

    public function __construct() {}

    /**
     * makePayment
     *
     * @param  mixed  $request
     */
    public static function makePayment($data = [])
    {

        try {
            $user = authCheck();
            $paymentMethod =  parent::geMethodInfo();
            $secretKey = $paymentMethod->keys['secret_key'] ?? '';
            Configuration::setXenditKey($secretKey);
            $apiInstance = new InvoiceApi();
            $successRoute = route('payment.success', 'xendit');
            $cancelRoute = route('payment.cancel');

            $totalAmount = Cart::totalPrice();

            if (session()->has('type') && session()->get('type') == 'subscription') {
                $totalAmount =  session()->get('subscription_price');
            }

            $amount =  $paymentMethod->conversation_rate ? $totalAmount / $paymentMethod->conversation_rate :  $totalAmount;

            $create_invoice_request = new CreateInvoiceRequest([
                'external_id' => uniqid(),
                'payer_email' => $user->email,
                'description' => translate('course Payment'),
                'amount' => round($amount * 100, 2),
                'currency' =>  $paymentMethod->currency,
                "success_redirect_url" => $successRoute,
                "failure_redirect_url" => $cancelRoute,
            ]);
            $createInvoice = $apiInstance->createInvoice($create_invoice_request);
            $invoiceId = $createInvoice['id'];
            $result = $apiInstance->getInvoiceById($invoiceId);
            return [
                'status' => 'success',
                "message" => translate('Payment created successfully!'),
                "gateway_url" => $result["invoice_url"]
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'message' => 'Payment failed! ' . $exception->getMessage(),
            ];
        }
    }
}
