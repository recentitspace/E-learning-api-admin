<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Models\Forum\Forum;
use Modules\LMS\Models\Forum\ForumPost;

class ForumController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;
        $page = (int) $request->query('page', 1);
        $search = trim((string) $request->query('search', ''));

        $query = Forum::query()->with(['subForums']);
        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%");
        }

        $paginator = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (Forum $forum) {
            return [
                'id' => $forum->id,
                'title' => $forum->title ?? null,
                'description' => $forum->description ?? null,
                'subforums' => $forum->subForums->map(fn($s) => [
                    'id' => $s->id,
                    'title' => $s->title ?? null,
                    'description' => $s->description ?? null,
                ])->values(),
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    public function posts(Request $request, $forumId): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;
        $page = (int) $request->query('page', 1);

        $query = ForumPost::query()->where('forum_id', $forumId)->with('user');
        $paginator = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (ForumPost $post) {
            return [
                'id' => $post->id,
                'title' => $post->title ?? null,
                'body' => $post->body ?? $post->content ?? null,
                'user' => $post->user ? [
                    'id' => $post->user->id,
                    'name' => $post->user->name ?? null,
                ] : null,
                'created_at' => $post->created_at,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }
} 