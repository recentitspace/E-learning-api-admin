<?php

namespace Modules\LMS\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Blog\BlogRepository;

class BlogController extends Controller
{
    public function __construct(protected BlogRepository $blog) {}

    /**
     * Display a listing of blogs.
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
        $response = BlogRepository::paginate(item: 10, options: $options, relations: [
            'admin',
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }
        ]);
        $blogs = $response['data'] ?? [];

        $countResponse = BlogRepository::trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::admin.blog.index', compact('blogs', 'countData'));
    }

    /**
     * Show form for creating a new blog.
     */
    public function create(): View
    {
        return view('portal::admin.blog.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if user has permission to add blogs
        if (!has_permissions($request->user(), ['add.blog'])) {
            return json_error('You have no permission.');
        }

        $blog = $this->blog->save($request);

        // Return response based on save status

        return $blog['status'] !== 'success'
            ? response()->json($blog)
            : $this->jsonSuccess('Blog has been save successfully!', route('blog.index'));
    }

    /**
     * Show form for editing the specified blog.
     */
    public function edit($id, Request $request)
    {
        // Check if user has permission to edit blogs
        if (!has_permissions($request->user(), ['edit.blog'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();

        // Retrieve blog for editing
        $blogResponse = $this->blog->first($id, relations: [
            'blogCategories',
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);

        $blog = $blogResponse['data'] ?? null;

        return view('portal::admin.blog.create', compact('blog'));
    }


    /**
     * Show form for editing the specified blog.
     */
    public function show($id, Request $request): View
    {

        // Retrieve blog for editing
        $response = $this->blog->first($id, relations: ['blogCategories'],  withTrashed: true);
        $blog = $response['data'] ?? null;
        return view('portal::admin.blog.view', compact('blog'));
    }


    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Check if user has permission to edit blogs
        if (!has_permissions($request->user(), ['edit.blog'])) {
            return json_error('You have no permission.');
        }

        $blog = $this->blog->update($id, $request);

        // Return response based on update status
        return $blog['status'] !== 'success'
            ? response()->json($blog)
            : $this->jsonSuccess('Blog has been updated successfully!', route('blog.index'));
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy($id, Request $request): JsonResponse
    {
        // Check if user has permission to delete blogs
        if (!has_permissions($request->user(), ['delete.blog'])) {
            return json_error('You have no permission.');
        }

        $blog = $this->blog->delete($id);
        $blog['url'] = route('blog.index');

        return response()->json($blog);
    }

    /**
     * Restore the specified blog from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a blog
        if (!has_permissions($request->user(), ['delete.blog'])) {
            return json_error('You have no permission.');
        }

        $response = BlogRepository::restore(id: $id);
        $response['url'] = route('blog.index');

        return response()->json($response);
    }

    /**
     * Change the status of the specified blog.
     */
    public function statusChange($id, Request $request): JsonResponse
    {
        // Check if user has permission to change blog status
        if (!has_permissions($request->user(), ['status.blog'])) {
            return json_error('You have no permission.');
        }

        $blog = $this->blog->statusChange($id);
        $blog['url'] = route('blog.index');
        return response()->json($blog);
    }
}
