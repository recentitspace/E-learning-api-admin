<?php

namespace Modules\LMS\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Financial\PayoutRepository;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = PayoutRepository::payoutReport();
        $response = PayoutRepository::paginate(options: [
            'where' => ['user_id' => authCheck()->id]
        ]);
        $payoutHistories = $response['data'] ??  [];

        return view('portal::organization.financial.payout.index', compact('reports', 'payoutHistories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function payoutRequest(Request $request)
    {
        //
        if (dotZeroRemove(authCheck()?->userable?->user_balance)) {
            $response =  PayoutRepository::payoutRequest();
            $response['url'] = route('organization.payout.index');
            return response()->json($response);
        }
        return response()->json([
            'status' => 'error',
            'message' =>  translate('You have no available balance')

        ]);
    }
}
