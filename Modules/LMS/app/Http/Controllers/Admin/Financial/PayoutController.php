<?php

namespace Modules\LMS\Http\Controllers\Admin\Financial;

use Illuminate\Http\Request;
use Modules\LMS\Enums\PayoutStatus;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Financial\PayoutRepository;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = PayoutRepository::paginate(options: [
            'orderBy' => ['created_at', 'DESC'],
        ], relations: ['user.userable.translations']);
        $payoutRequests = $response['data'] ??  [];
        $reports = PayoutRepository::adminReport();
        return view('portal::admin.financial.payout.index', compact('payoutRequests', 'reports'));
    }


    /**
     *  statusChange
     *
     * @param  $id  $id
     * @param  mixed  $request
     */
    public function statusChange($id, Request $request)
    {
        // Check if the user has the required permission to edit a course.
        if (!has_permissions($request->user(), ['approved-status.payout'])) {
            // If not, return an error response.
            return json_error('You have no permission.');
        }
        $result = PayoutRepository::statusChange($id, $request);
        toastr()->success(translate(ucfirst($request->status) . ' Successfully'));

        return response()->json($result);
    }
}
