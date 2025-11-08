<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Enums\PurchaseStatus;
use Modules\LMS\Models\Purchase\Purchase;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function offlinePayment()
    {

        $offlinePayments = Purchase::with('user', 'paymentDocument')->where(['payment_method' => 'offline',  'type' => 'purchase'])
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return view('portal::admin.financial.payment.offline.index', compact('offlinePayments'));
    }

    public function changePaymentStatus($id, Request $request)
    {

        if (!has_permissions($request->user(), ['offline.status.payment'])) {
            // If not, return an error response.
            return json_error('You have no permission.');
        }
        $purchase = Purchase::with('purchaseDetails')->where('id', $id)->first();
        $purchase->update([
            'status' => $request->status
        ]);
        if ($request->status == 'success') {
            $purchase->purchaseDetails()->update([
                'status' => PurchaseStatus::PROCESSING
            ]);
        }
        return response()->json(['status' => 'success', 'type' => true]);
    }
}
