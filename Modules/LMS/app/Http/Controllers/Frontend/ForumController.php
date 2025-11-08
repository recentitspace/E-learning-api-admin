<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Forum\ForumRepository;

class ForumController extends Controller
{
    public function __construct(protected ForumRepository $forum) {}

    /**
     * Display a listing of the resource.
     */
    public function forumsList()
    {
        return $this->forum->forumsList();
    }

    public function forumPost(Request $request)
    {
        $forumPost = $this->forum->forumPost($request);
        if ($forumPost['status'] !== 'success') {
            return response()->json($forumPost);
        }
        toastr()->success(translate('Post has been saved successfully!'));

        return response()->json(['status' => $forumPost['status']]);
    }
}
