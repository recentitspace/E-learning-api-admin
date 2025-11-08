<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\PaymentMethodRepository;

class PaymentMethodController extends Controller
{
    public function __construct(protected PaymentMethodRepository $payment) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = $this->payment->paginate(10)['data'];
        return view('portal::admin.paymethod.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('portal::admin.paymethod.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add a payment method.
        if (!has_permissions($request->user(), ['add.payment-method'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the new payment method.
        $payment = $this->payment->save($request);

        if ($payment['status'] !== 'success') {
            return response()->json($payment);
        }


        return $this->jsonSuccess('Payment Method added successfully!', route('payment-method.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $method = $this->payment->first($id)['data'];
        return view('portal::admin.paymethod.create', compact('method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // Check if the user has permission to edit a payment method.
        if (!has_permissions($request->user(), ['edit.payment-method'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the payment method.
        $payment = $this->payment->update($id, $request);

        if ($payment['status'] !== 'success') {
            return response()->json($payment);
        }
        return $this->jsonSuccess('Payment Method updated successfully!', route('payment-method.index'));
    }

    public function statusChange($id, Request $request)
    {
        // Check if the user has permission to change the status of a payment method.
        if (!has_permissions($request->user(), ['status.payment-method'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status of the payment method.
        $payment = $this->payment->statusChange($id);

        return response()->json($payment);
    }
}
