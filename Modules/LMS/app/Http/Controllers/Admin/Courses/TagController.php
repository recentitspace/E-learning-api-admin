<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Repositories\Courses\TagRepository;

class TagController extends Controller
{

    /**
     * TagRepository constructor.
     *
     * @param TagRepository $tag
     */
    public function __construct(protected TagRepository $tag) {}

    /**
     * Display a listing of tags.
     */
    public function index(): View
    {
        // Paginate tags with 10 items per page and extract the data.
        $response = $this->tag->paginate(item: 10, relations: [
            'translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }
        ]);
        $tags = $response['data'];

        // Render the index view with tags.
        return view('portal::admin.course.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create(): View
    {
        // Render the tag creation form view.
        return view('portal::admin.course.tag.form');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a tag.
        if (!has_permissions($request->user(), ['add.tag'])) {
            return json_error('You have no permission.');
        }

        // Add a slug to the request using the tag name.
        $request->request->add(['slug' => Str::slug($request->name)]);

        // Save the tag and check for errors.
        $response = $this->tag->save($request);
        if ($response['status'] != 'success') {
            return response()->json($response);
        }

        // Handle modal-specific response if applicable.
        if (isset($request->modal_type)) {
            return response()->json([
                'status' => 'success',
                'modal_hide' => $request->modal_type
            ]);
        }
        // Add success message and return a success response.
        toastr()->success(translate('Tag has been saved successfully!'));
        return response()->json([
            'status' => 'success',
            'url' => route('tag.index'),
        ]);
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit the tag.
        if (!has_permissions($request->user(), ['edit.tag'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the tag and render the form view if successful.
        $response = $this->tag->first($id, relations: [
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $tag = $response['data'];
        return view('portal::admin.course.tag.form', compact('tag'));
        // If tag not found, return the 404 view.
    }


    public function show($id)
    {
        $response = $this->tag->first($id);
        // Return the error response if the save operation failed.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $tag = $response['data'] ?? null;

        return view('portal::admin.course.tag.view', compact('tag'));
    }


    /**
     * Update the specified tag in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit the tag.
        if (!has_permissions($request->user(), ['edit.tag'])) {
            return json_error('You have no permission.');
        }

        // Add a slug to the request using the tag name.
        $request->request->add(['slug' => Str::slug($request->name)]);

        // Update the tag and return the appropriate response.
        $response = $this->tag->update($id, $request->all());
        if ($response['status'] != 'success') {
            return response()->json($response);
        }

        return $this->jsonSuccess('Tag has been updated successfully!',  route('tag.index'));
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete the tag.
        if (!has_permissions($request->user(), ['delete.tag'])) {
            return json_error('You have no permission.');
        }
        // Delete the tag and return the response.
        $tag = $this->tag->delete($id);
        $tag['url'] = route('tag.index');
        return response()->json($tag);
    }
}
