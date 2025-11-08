<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\LevelRepository;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected LevelRepository $level) {}

    /**
     * Display the list of levels.
     */
    public function index(Request $request): View
    {
        // Paginate the levels, fetching 10 per page.

        $options = [];
        $filterType = '';
        if ($request->has('filter')) {
            $filterType = $request->filter ?? '';
        }
        switch ($filterType) {
            case 'trash':
                $options['onlyTrashed'] = [];
                break;
            case 'all':
                $options['withTrashed'] = [];
                break;
        }


        $response = $this->level::paginate(10, options: $options, relations: [
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }]
        );
        $levels = $response['data'] ?? [];

        $countResponse = $this->level->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }
        // Return the index view with the levels data.

        return view('portal::admin.course.level.index', compact('levels', 'countData'));
    }

    /**
     * Show the form to create a new level.
     */
    public function create(): View
    {
        // Return the form view for creating a new level.
        return view('portal::admin.course.level.form');
    }

    /**
     * Store a newly created level in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a level.

        if (!has_permissions($request->user(), ['add.level'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the new level data
        $response = $this->level->save($request);
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        return $this->jsonSuccess('Level has been saved successfully!',  route('level.index'));
    }


    public function show($id)
    {
        $response = $this->level->first($id, withTrashed: true);
        // Return the error response if the save operation failed.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $level = $response['data'] ?? null;

        return view('portal::admin.course.level.view', compact('level'));
    }

    /**
     * Show the form to edit the specified level.
     */
    public function edit($id, Request $request)
    {
        if (!has_permissions($request->user(), ['edit.level'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        $response = $this->level->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        // Return the error response if the save operation failed.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $level = $response['data'] ?? null;
        return view('portal::admin.course.level.form', compact('level'));
    }

    /**
     * Update the specified level in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit a level.

        if (!has_permissions($request->user(), ['edit.level'])) {
            return json_error('You have no permission.');
        }
        // Attempt to update the level data.

        $response = $this->level->update($id, $request);

        // Return the error response if the update operation failed.
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        return $this->jsonSuccess('Level has been updated successfully!',  route('level.index'));
    }


    /**
     * Remove the specified level from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete a level.
        if (!has_permissions($request->user(), ['delete.level'])) {
            return json_error('You have no permission.');
        }
        // Attempt to delete the level.
        $response = $this->level->delete(id: $id);
        $response['url'] = route('level.index');
        return response()->json($response);
    }


    /**
     * restore the specified level from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a level
        if (!has_permissions($request->user(), ['delete.level'])) {
            return json_error('You have no permission.');
        }
        $response = $this->level->restore(id: $id);
        $response['url'] = route('level.index');
        return response()->json($response);
    }
}
