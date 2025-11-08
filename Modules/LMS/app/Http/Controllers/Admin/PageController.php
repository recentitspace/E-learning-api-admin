<?php

namespace Modules\LMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Page\PageRepository;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response =  PageRepository::paginate(10, relations: ['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);
        $pages = $response['data'] ?? [];
        return view('portal::admin.page.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)

    {
        $locale = $request->locale ?? app()->getLocale();
        $response = PageRepository::first($id,  relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        $page = $response['data'] ?? [];


        return view('portal::admin.page.form', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!has_permissions($request->user(), ['edit.page'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        // Fetch the page data
        $response = PageRepository::update($id, $request);
        // If update operation failed, return the error response
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        // If successful, return a success response with a redirect URL
        return $this->jsonSuccess(
            'Page has been updated successfully!',
            route('page.index')
        );
    }
}
