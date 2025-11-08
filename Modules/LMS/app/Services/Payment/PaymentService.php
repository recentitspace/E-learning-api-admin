<?php

namespace Modules\LMS\Services\Payment;

use Modules\LMS\Repositories\Order\OrderRepository;
use Modules\LMS\Models\PaymentMethod;

abstract class PaymentService
{
    protected $gateway;

    protected static $methodName;

    /**
     * Method makePayment
     *
     * @param $data
     *
     */
    abstract static public function makePayment($data = null);
    /**
     * geMethodInfo
     *
     * @param string
     * @return object
     */
    public static function geMethodInfo()
    {
        return PaymentMethod::where('method_name', static::$methodName)->first();
    }

    /**
     *
     * @param string $method  like paypal, stripe
     */
    public static function success($method, $data = [])
    {
        $response = OrderRepository::placeOrder($method, $data);
        return $response;
    }
}
