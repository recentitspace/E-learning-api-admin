<?php

namespace Modules\LMS\Http\Controllers\Admin\SupportTicket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\SupportTicket\SupportCategoryRepository;

class SupportCategoryController extends Controller
{
    public function __construct(protected SupportCategoryRepository $support) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch paginated support categories
        $supportCategories = $this->support->paginate(10)['data'];
        return view('portal::admin.support.category.index', compact('supportCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portal::admin.support.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add a support category
        if (!has_permissions($request->user(), ['add.category.support'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the new support category
        $supportCategory = $this->support->save($request);

        if ($supportCategory['status'] !== 'success') {
            return response()->json($supportCategory);
        }
        return $this->jsonSuccess('Support Category saved successfully!', route('support-ticket.category.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a support category
        if (!has_permissions($request->user(), ['edit.category.support'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        $locale = $request->locale ?? app()->getLocale();
        $response = $this->support->first($id,  relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        $supportCategory = $response['data'] ?? [];
        return view('portal::admin.support.category.create', compact('supportCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($id, Request $request)
    {
        // Retrieve the support category for editing
        $response = $this->support->first($id);
        $supportCategory = $response['data'] ?? '';
        return view('portal::admin.support.category.view', compact('supportCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to edit a support category
        if (!has_permissions($request->user(), ['edit.category.support'])) {
            return json_error('You have no permission.');
        }
        // Attempt to update the support category
        $supportCategory = $this->support->update($id, $request);

        if ($supportCategory['status'] !== 'success') {
            return response()->json($supportCategory);
        }
        return $this->jsonSuccess('Support Category updated successfully!', route('support-ticket.category.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function statusChange($id, Request $request)
    {

        // Check if the user has permission to change the status of a support category
        if (!has_permissions($request->user(), ['status.category.support'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status of the support category
        $supportCategory = $this->support->statusChange($id);

        return response()->json($supportCategory);
    }

    public function destroy($id, Request $request)
    {

        // Check if the user has permission to delete a support category
        if (!has_permissions($request->user(), ['delete.category.support'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the support category
        $supportCategory = $this->support->delete($id);
        $supportCategory['url'] = route('support-ticket.category.index');

        return response()->json($supportCategory);
    }
}
