<?php

namespace Modules\LMS\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Coupon\CouponRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class CouponController extends Controller
{
    public function __construct(protected CouponRepository $coupon) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        //
        $response = $this->coupon->paginate(item: 10);
        $coupons = $response['data'];

        return view('portal::admin.coupon.index', compact('coupons'));
    }

    /**
     * create
     */
    public function create(): View
    {
        //

        return view('portal::admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Check if the user has permission to add a coupon.
        if (!has_permissions($request->user(), ['add.coupon'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the coupon and capture the response.
        $coupon = $this->coupon->save($request);

        // Check if the coupon was saved successfully.
        if ($coupon['status'] !== 'success') {
            return response()->json($coupon);
        }

        return $this->jsonSuccess('Coupon has been saved successfully!', route('coupon.index'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // Attempt to fetch the coupon data.
        $response = $this->coupon->first($id);
        $coupon = $response['data'];
        return response()->json($coupon);
    }

    /**
     * Edit the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a coupon.
        if (!has_permissions($request->user(), ['edit.coupon'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        // Attempt to fetch the coupon for editing.
        $response = $this->coupon->first($id, relations: ['categories', 'courses']);
        $coupon = $response['data'];

        return view('portal::admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // Check if the user has permission to edit a coupon.
        if (!has_permissions($request->user(), ['edit.coupon'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the coupon and capture the response.
        $coupon = $this->coupon->update($id, $request);

        // Check if the coupon was updated successfully.
        if ($coupon['status'] !== 'success') {
            return response()->json($coupon);
        }

        return $this->jsonSuccess(
            'Coupon has been updated successfully!',
            route('coupon.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {

        // Check if the user has permission to delete a coupon.
        if (!has_permissions($request->user(), ['delete.coupon'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the coupon and return the response.
        $coupon = $this->coupon->delete($id);

        return response()->json($coupon);
    }

    /**
     *  statusChange
     *
     * @param  $id  $id
     */
    public function statusChange($id, Request $request): JsonResponse
    {
        // Check if the user has permission to change the status of a coupon.
        if (!has_permissions($request->user(), ['edit.coupon'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status of the coupon and return the response.
        $coupon = $this->coupon->statusChange($id);

        return response()->json($coupon);
    }
}
