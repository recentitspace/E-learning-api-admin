<?php

namespace Modules\LMS\Http\Controllers\Admin\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\Category\CategoryRepository;


class CategoryController extends Controller
{


    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $category
     */
    public function __construct(protected CategoryRepository $category) {}

    /**
     * Display a listing of categories.
     *
     * @return View
     */
    public function index(Request $request)
    {
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
        $locale =  app()->getLocale()  ??  app('default_language');
        $response = $this->category->paginate(50,  relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }], options: $options);

        $categories = $response['data'] ?? [];

        $countResponse = $this->category->trashCount();
        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        // Return the view with the list of categories
        return view('portal::admin.category.index', compact('categories', 'countData'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new category
        return view('portal::admin.category.form');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        // Check if the user has permission to add a category
        if (!has_permissions($request->user(), ['add.category'])) {
            return json_error('You have no permission.');
        }

        // Add a slug to the request based on the category title
        $request->request->add(['slug' => Str::slug($request->title)]);

        // Save the new category
        $category = $this->category->save($request);
        if ($category['status'] !== 'success') {
            return response()->json($category);
        }
        return $this->jsonSuccess('Category has been saved successfully!', route('category.index'));
    }

    /**
     * Show the form for view the specified category.
     *
     * @return View
     */
    public function show($id): View
    {
        // Return the view to create a new icon
        $response = $this->category->first($id, withTrashed: true);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $category = $response['data'];
        return view('portal::admin.category.view', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(int $id, Request $request, $locale = null)
    {
        // Check if the user has permission to edit the category
        if (!has_permissions($request->user(), ['edit.category'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();

        // Retrieve the category data for editing
        $category = $this->category->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        if ($category['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $category = $category['data'];
        return view('portal::admin.category.form', compact('category', 'locale'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {

        // Check if the user has permission to update the category
        if (!has_permissions($request->user(), ['edit.category'])) {
            return json_error('You have no permission.');
        }

        // Update the category data
        $category = $this->category->update($id, $request);
        if ($category['status'] !== 'success') {
            return response()->json($category);
        }
        return $this->jsonSuccess('Category has been updated successfully!', route('category.index'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete the category
        if (!has_permissions($request->user(), ['delete.category'])) {
            return json_error('You have no permission.');
        }

        // Delete the category
        $response = $this->category->delete(id: $id, data: [
            'status' => 0
        ]);
        $response['url'] = route('category.index');
        return response()->json($response);
    }

    /**
     * Change the status of the specified category.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to change the category's status
        if (!has_permissions($request->user(), ['status.category'])) {
            return json_error('You have no permission.');
        }

        // Change the status of the category
        $category = $this->category->statusChange(id: $id);
        return response()->json($category);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a category
        if (!has_permissions($request->user(), ['delete.category'])) {
            return json_error('You have no permission.');
        }
        $response = $this->category->restore(id: $id);
        $response['url'] = route('category.index');
        return response()->json($response);
    }
}
