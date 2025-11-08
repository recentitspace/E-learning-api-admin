<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\PaymentMethod;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $paymentMethods = [
            [
                'method_name' => 'Stripe',
                'slug' => 'stripe',
                'currency' => 'USD',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-0kPLJgOe.png',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Paypal',
                'slug' => 'paypal',
                'currency' => 'USD',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-Dyu4GFdk.svg',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Razorpay',
                'slug' => 'razorpay',
                'currency' => 'INR',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-7Djey1BX.png',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'xendit',
                'slug' => 'xendit',
                'currency' => 'IDR',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-NAXoWT6H.png',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Paystack',
                'slug' => 'paystack',
                'currency' => 'ZAR',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-8tWnmaIX.png',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),

            ],
            [
                'method_name' => 'Offline',
                'slug' => 'offline',
                'currency' => 'BDT',
                'conversation_rate' => null,
                'keys' => null,
                'enabled_test_mode' => 1,
                'logo' =>  'lms-OndMChdV.svg',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'method_name' => 'WaafiPay',
                'slug' => 'waafipay',
                'currency' => 'USD',
                'conversation_rate' => null,
                'keys' => [
                    'merchant_uid' => 'your_merchant_uid',
                    'api_user_id' => 'your_api_user_id',
                    'api_key' => 'your_api_key',
                    'payment_method' => 'MWALLET_ACCOUNT',
                ],
                'enabled_test_mode' => 1,
                'logo' =>  'lms-waafipay.png',
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::updateOrCreate(['method_name' => $paymentMethod['method_name']], $paymentMethod);
        }
    }
}
