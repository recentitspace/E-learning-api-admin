<?php

namespace Modules\LMS\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Forum\SubForumRepository;

class SubForumController extends Controller
{
    public function __construct(protected SubForumRepository $subForum) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subForums = $this->subForum->paginate(10)['data'];
        return view('portal::admin.forum.sub-forum.index', compact('subForums'));
    }


    /* Show the form for creating a new resource.
    */
    public function create()
    {
        return view('portal::admin.forum.sub-forum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add a sub-forum.
        if (!has_permissions($request->user(), ['add.sub-forum'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the sub-forum and capture the response.
        $subForum = $this->subForum->save($request);

        // Check if the sub-forum was saved successfully.
        if ($subForum['status'] !== 'success') {
            return response()->json($subForum);
        }
        return $this->jsonSuccess('Sub Forum has been saved successfully',  route('sub-forum.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a sub-forum.
        if (!has_permissions($request->user(), ['edit.sub-forum'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Attempt to retrieve the sub-forum and handle the response.
        $response = $this->subForum->first($id);
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        $subForum = $response['data'];

        return view('portal::admin.forum.sub-forum.create', compact('subForum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to edit a sub-forum.
        if (!has_permissions($request->user(), ['edit.sub-forum'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the sub-forum and capture the response.
        $response = $this->subForum->update($id, $request);
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        return $this->jsonSuccess('Sub Forum has been saved successfully',  route('sub-forum.index'));
    }

    /**
     * Method destroy
     *
     * @param  int  $id
     *
     * @response JsonResponse
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to delete a sub-forum.
        if (!has_permissions($request->user(), ['delete.sub-forum'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the sub-forum and return the response.
        $subForum = $this->subForum->delete($id);
        return response()->json($subForum);
    }
}
