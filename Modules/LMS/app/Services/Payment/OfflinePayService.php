<?php

namespace Modules\LMS\Services\Payment;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OfflinePayService extends PaymentService
{
    protected $gateway;
    protected static $methodName = 'offline';
    /**
     * Method makePayment
     *
     */
    public static function makePayment($request = null)
    {
        $validator = Validator::make($request->all(), [
            'bank_document' => 'required|mimes:png,jpg,pdf,txt,docx,jpeg'
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'errors' => $validator->errors()
            ];
        }

        $folder = "lms/offline/documents";
        if ($request->hasFile('bank_document')) {
            $source = $request->file('bank_document');
            $image_name =   Str::random(8) . '.' . str_replace(' ', '-', $source->getClientOriginalExtension());
            $source->storeAs('public/' . $folder, $image_name, 'LMS');
        }
        return [
            'status' => 'success',
            'url' => route('payment.success', ['method' => 'offline', 'document' => $image_name])
        ];
    }
}
