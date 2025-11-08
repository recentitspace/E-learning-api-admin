<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected CurrencyRepository $currency) {}

    public function index()
    {
        $response = $this->currency->paginate(15);
        $currencies = $response['data'] ?? [];
        return view('portal::admin.currency.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portal::admin.currency.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if (!has_permissions($request->user(), ['add.currency'])) {
            return json_error('You have no permission.');
        }
        $currency = explode('-', $request->currency);
        $request->merge([
            'name' => $currency[2],
            'code' => $currency[1],
            'symbol' => $currency[0],
            'status' => $request->status ?? 1,
        ]);
        $response = $this->currency->save($request->all());
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        return $this->jsonSuccess('Currency has been saved successfully', route('currency.index'));
    }
    /**
     * Show the specified resource.
     */
    public function edit($id)
    {
        $response = $this->currency->first($id);
        $currency = $response['data'] ?? null;
        return view('portal::admin.currency.form', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {

        if (!has_permissions($request->user(), ['edit.currency'])) {
            return json_error('You have no permission.');
        }
        $currency = explode('-', $request->currency);
        $request->merge([
            'name' => $currency[2],
            'code' => $currency[1],
            'symbol' => $currency[0],
            'status' => $request->status ?? 1,
        ]);
        $response = $this->currency->update($id, $request->all());
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        return $this->jsonSuccess('Currency has been update successfully', route('currency.index'));
    }

    /**
     * Change the status of the specified currency.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to change the currency's status
        if (!has_permissions($request->user(), ['status.currency'])) {
            return json_error('You have no permission.');
        }
        // Change the status of the category
        $response = $this->currency->statusChange(id: $id);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to change the currency's status
        if (!has_permissions($request->user(), ['delete.currency'])) {
            return json_error('You have no permission.');
        }
        $response = $this->currency->delete(id: $id);
        $response['url'] = route('currency.index');
        return response()->json($response);
    }
}
