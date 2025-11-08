<?php

namespace Modules\LMS\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Coupon\CouponTypeRepository;

class CouponTypeController extends Controller
{
    public function __construct(protected CouponTypeRepository $type) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $couponTypes = $this->type->get();

        return response()->json($couponTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $couponType = $this->type->save($request);

        return response()->json($couponType);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
        $couponType = $this->type->first(value: $id);

        return response()->json($couponType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $couponType = $this->type->update($id, $request);

        return response()->json($couponType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $couponType = $this->type->delete($id);

        return response()->json($couponType);
    }
}
