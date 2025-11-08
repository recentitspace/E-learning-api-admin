<?php

namespace Modules\LMS\Http\Controllers\Admin\Blog;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Blog\BlogCategoryRepository;

class BlogCategoryController extends Controller
{

    public function __construct(protected BlogCategoryRepository $category) {}

    /**
     * Display a listing of blog categories.
     */
    public function index(Request $request): View
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
        $response = $this->category->paginate(10, options: $options, relations: [
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }
        ]);
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

        return view('portal::admin.blog.category.index', compact('categories', 'countData'));
    }

    /**
     * Show form for creating a new blog category.
     */
    public function create(): View
    {
        return view('portal::admin.blog.category.create');
    }

    /**
     * Store a newly created blog category in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if user has permission to add blog categories
        if (!has_permissions($request->user(), ['add.blog.category'])) {
            return json_error('You have no permission.');
        }

        // Add slug to request data
        $request->merge(['slug' => Str::slug($request->name)]);
        $category = $this->category->save($request->all());

        // Return response based on save status

        return $category['status'] !== 'success'
            ? response()->json($category)
            : $this->jsonSuccess('Category has been saved successfully!', route('blog.category.index'));
    }

    /**
     * Show form for editing the specified blog category.
     */
    public function edit($id, Request $request)
    {
        // Check if user has permission to edit blog categories
        if (!has_permissions($request->user(), ['edit.blog.category'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        $locale = $request->locale ?? app()->getLocale();
        // Retrieve blog category for editing
        $response = $this->category->first($id, relations: [
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);
        $category =   $response['data'] ?? null;

        return view('portal::admin.blog.category.create', compact('category'));
    }


    /**
     * Show form for editing the specified blog category.
     */
    public function show($id, Request $request): View
    {

        // Retrieve blog category for editing
        $response = $this->category->first($id,  withTrashed: true);
        $category =   $response['data'] ?? null;
        return view('portal::admin.blog.category.view', compact('category'));
    }

    /**
     * Update the specified blog category in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Check if user has permission to edit blog categories
        if (!has_permissions($request->user(), ['edit.blog.category'])) {
            return json_error('You have no permission.');
        }



        // Add slug to request data
        $request->merge(['slug' => Str::slug($request->name)]);
        $data = $request->all();

        $category = $this->category->update($id, $data);

        // Return response based on update status
        return $category['status'] !== 'success'
            ? response()->json($category)
            : $this->jsonSuccess('Category has been updated successfully!', route('blog.category.index'));
    }


    /**
     * Remove the specified blog Category from storage.
     */
    public function destroy($id, Request $request): JsonResponse
    {
        // Check if user has permission to delete blogs
        if (!has_permissions($request->user(), ['delete.blog.category'])) {
            return json_error('You have no permission.');
        }

        $category = $this->category->delete($id);
        $category['url'] = route('blog.category.index');
        return response()->json($category);
    }


    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a category
        if (!has_permissions($request->user(), ['delete.blog.category'])) {
            return json_error('You have no permission.');
        }
        $response = $this->category->restore(id: $id);
        $response['url'] = route('blog.category.index');
        return response()->json($response);
    }
}
