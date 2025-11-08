<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\LMS\Classes\Cart;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Cart\CartRepository;

class CartController extends Controller
{
    public function __construct(
        protected CartRepository $cart,
    ) {}
    /**
     *  addToCart
     *
     * @param  int  $id
     */
    public function addToCart(Request $request)
    {
        session()->forget('type');
        session()->forget('subscription_price');
        session()->forget('subscription_id');

        $result = $this->cart->addToCart($request);
        return response()->json($result);
    }

    /**
     * removeCart
     *
     * @param  mixed  $id
     */
    public function removeCart(Request $request)
    {
        return $this->cart->removeCart($request->id);
    }

    /**
     * cartCourseList
     */
    public function cartCourseList()
    {
        $data['cartCourses'] = Cart::get();
        $data['totalPrice'] = Cart::totalPrice();
        $data['discountAmount'] = Cart::discountAmount();

        return view('theme::cart.index', compact('data'));
    }
    /**
     * Method applyCoupon
     */
    public function applyCoupon(Request $request)
    {
        if (!authCheck()) {
            return response()->json([
                'status' => 'error',
                'message' => translate('please Login'),

            ]);
        }
        return $this->cart->applyCoupon($request->coupon_code);
    }
}
