<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Blog\BlogRepository;

class BlogController extends Controller
{
    public function __construct(protected BlogRepository $blog) {}

    /**
     * Display a listing of the resource.
     */
    public function blogs(Request $request)
    {
        $blogs = $this->blog->blogList($request);

        return view('theme::blog.index', compact('blogs'));
    }

    public function blogDetail($slug)
    {
        $blog = $this->blog->blogDetail($slug);
        if (!$blog) {
            return view('theme::404');
        }

        return view('theme::blog.blog-detail', compact('blog'));
    }

    public function store(Request $request)
    {
        $result = $this->blog->commentStore($request);
        if ($result['status'] !== 'success') {
            return $result;
        }

        toastr()->success($result['message']);
        return response()->json([
            'status' => $result['status'],
            'type' => 'reload'
        ]);
    }
}
