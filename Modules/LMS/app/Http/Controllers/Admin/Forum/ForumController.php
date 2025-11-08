<?php

namespace Modules\LMS\Http\Controllers\Admin\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Forum\ForumRepository;

class ForumController extends Controller
{
    public function __construct(protected ForumRepository $forum) {}

    /**
     * forumCategory
     */
    public function forumCategory()
    {
        return view('portal::admin.forum.category.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums = $this->forum->paginate(10, relations: ['subForums', 'forumPosts']);
        $forums = $forums['data'];

        return view('portal::admin.forum.index', compact('forums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portal::admin.forum.create');
    }

    /**
     * Store a newly created forum resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a forum.
        if (!has_permissions($request->user(), ['add.forum'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the forum and capture the response.
        $forum = $this->forum->save($request);

        // Check if the forum was saved successfully.
        if ($forum['status'] !== 'success') {
            return response()->json($forum);
        }

        return $this->jsonSuccess('Forum has been saved successfully.', route('forum.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit the forum.
        if (!has_permissions($request->user(), ['edit.forum'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Attempt to retrieve the forum and handle the response.
        $forum = $this->forum->first($id);

        // Check if the forum was retrieved successfully.
        if ($forum['status'] !== 'success') {
            return response()->json($forum);
        }

        $forum = $forum['data'];

        return view('portal::admin.forum.create', compact('forum'));
    }

    /**
     * Update the specified forum resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Check if the user has permission to edit the forum.
        if (!has_permissions($request->user(), ['edit.forum'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the forum and capture the response.
        $forum = $this->forum->update($id, $request);

        // Check if the forum was updated successfully.
        if ($forum['status'] !== 'success') {
            return response()->json($forum);
        }

        return $this->jsonSuccess('Forum has been updated successfully.', route('forum.index'));
    }

    /**
     * Change the status of the specified forum resource.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to change the forum status.
        if (!has_permissions($request->user(), ['status.forum'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status of the forum and capture the response.
        $forum = $this->forum->statusChange($id);

        return response()->json($forum);
    }

    /**
     * Remove the specified forum resource from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete the forum.
        if (!has_permissions($request->user(), ['delete.forum'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the forum and capture the response.
        $forum = $this->forum->delete($id);

        return response()->json($forum);
    }
}
