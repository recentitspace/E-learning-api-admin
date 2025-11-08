<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Services\Payment\PaymentService;

class PaymentController extends Controller
{
    /**
     * Method success
     */
    public function success($method, Request $request)
    {
        PaymentService::success($method, $request->all());
        return redirect()->route('transaction.success');
    }
    /**
     * paypalCancel
     *
     * @return View
     */
    public function cancel()
    {
        return redirect()->route('checkout.page');
    }
}
