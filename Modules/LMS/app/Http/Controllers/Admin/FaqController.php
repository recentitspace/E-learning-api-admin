<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\LMS\Repositories\General\FaqRepository;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected FaqRepository $faq) {}

    public function index()
    {
        //
        $faqs = $this->faq::paginate(item: 10);
        $faqs = $faqs['data'];

        return view('portal::admin.faq.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('portal::admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        // Check if the user has permission to add an FAQ
        if (!has_permissions($request->user(), ['add.faq'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the new FAQ
        $response = $this->faq->save($request->all());

        // If save operation failed, return the error response
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        // If successful, return a success response with a redirect URL
        return $this->jsonSuccess(
            'FAQ has been saved successfully!',
            route('faq.index')
        );
    }

    /**
     * Show the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit an FAQ
        if (!has_permissions($request->user(), ['edit.faq'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Fetch the FAQ data
        $response = $this->faq->first($id);

        // If the data retrieval failed, handle the error accordingly
        if ($response['status'] !== 'success') {
            toastr()->error(translate('Failed to retrieve the FAQ data.'));
            return redirect()->back();
        }

        // Extract the FAQ data and pass it to the view
        $faq = $response['data'];
        return view('portal::admin.faq.create', compact('faq'));
    }




    /**
     * Show the specified resource.
     */
    public function show($id)
    {

        // Fetch the FAQ data
        $response = $this->faq->first($id);

        // If the data retrieval failed, handle the error accordingly
        if ($response['status'] !== 'success') {
            toastr()->error('Failed to retrieve the FAQ data.');
            return redirect()->back();
        }

        // Extract the FAQ data and pass it to the view
        $faq = $response['data'] ?? null;
        return view('portal::admin.faq.view', compact('faq'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {

        // Check if the user has permission to edit an FAQ
        if (!has_permissions($request->user(), ['edit.faq'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the FAQ
        $response = $this->faq->update($id, $request->all());

        // If update operation failed, return the error response
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        // If successful, return a success response with a redirect URL
        return $this->jsonSuccess(
            'FAQ has been updated successfully!',
            route('faq.index')
        );
    }


    /**
     * Remove the specified language from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check user permission to delete a language
        if (!has_permissions($request->user(), ['delete.faq'])) {
            return json_error('You have no permission.');
        }
        $faq = $this->faq->delete(id: $id);
        $faq['url'] = route('faq.index');
        return response()->json($faq);
    }
}
