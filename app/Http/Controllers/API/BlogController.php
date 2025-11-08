<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Models\Blog\Blog;
use Modules\LMS\Models\BlogComment;

class BlogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;
        $page = (int) $request->query('page', 1);
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category_id');
        $locale = $request->query('locale');

        $query = Blog::query()->with(['blogCategories'])->whereNull('deleted_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        if (!is_null($categoryId) && $categoryId !== '') {
            $query->whereHas('blogCategories', function ($q) use ($categoryId) {
                $q->where('blog_category_id', $categoryId);
            });
        }
        if ($locale) {
            $query->with(['translations' => function ($q) use ($locale) { $q->where('locale', $locale); }]);
        }

        $paginator = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (Blog $blog) use ($locale) {
            $translation = null;
            if ($locale && $blog->relationLoaded('translations')) {
                $translation = $blog->translations->first();
            }
            $title = $translation->title ?? $blog->title ?? null;
            $short = $translation->short_description ?? $blog->short_description ?? null;

            return [
                'id' => $blog->id,
                'title' => $title,
                'slug' => $blog->slug ?? Str::slug((string) $title),
                'thumbnail' => $blog->thumbnail ?? null,
                'short_description' => $short,
                'categories' => $blog->blogCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name ?? $c->title ?? null])->values(),
                'published_at' => $blog->published_at ?? $blog->created_at,
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

    public function show($blog): JsonResponse
    {
        $locale = request()->query('locale');
        $query = Blog::query()->with(['blogCategories', 'comments.user'])->whereNull('deleted_at');
        $model = is_numeric($blog)
            ? $query->find($blog)
            : $query->where('slug', $blog)->first();

        if (!$model) {
            return response()->json(['status' => 'error', 'message' => 'Blog not found'], 404);
        }

        $translation = null;
        if ($locale) {
            $model->load(['translations' => function ($q) use ($locale) { $q->where('locale', $locale); }]);
            $translation = $model->translations->first();
        }

        $title = $translation->title ?? $model->title ?? null;
        $content = $translation->description ?? $model->content ?? $model->description ?? null;

        $data = [
            'id' => $model->id,
            'title' => $title,
            'slug' => $model->slug ?? Str::slug((string) $title),
            'content' => $content,
            'thumbnail' => $model->thumbnail ?? null,
            'categories' => $model->blogCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name ?? $c->title ?? null])->values(),
            'comments' => $model->comments->map(function ($c) {
                return [
                    'id' => $c->id,
                    'body' => $c->body ?? $c->comment ?? null,
                    'user' => $c->user ? [
                        'id' => $c->user->id,
                        'name' => $c->user->name ?? trim(($c->user->userable->first_name ?? '').' '.($c->user->userable->last_name ?? '')),
                    ] : null,
                    'replies' => $c->replies->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'body' => $r->body ?? $r->comment ?? null,
                        ];
                    })->values(),
                ];
            })->values(),
            'published_at' => $model->published_at ?? $model->created_at,
        ];

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function comment(Request $request, $blog): JsonResponse
    {
        $request->validate([
            'comment' => 'required|string|min:1',
            'reply_id' => 'nullable|integer',
        ]);

        $model = Blog::query()->whereNull('deleted_at')
            ->when(is_numeric($blog), fn($q) => $q->where('id', $blog), fn($q) => $q->where('slug', $blog))
            ->first();

        if (!$model) {
            return response()->json(['status' => 'error', 'message' => 'Blog not found'], 404);
        }

        $comment = BlogComment::create([
            'blog_id' => $model->id,
            'user_id' => auth()->id(),
            'reply_id' => $request->input('reply_id'),
            'comment' => $request->input('comment'),
        ]);

        return response()->json(['status' => 'success', 'data' => [
            'id' => $comment->id,
            'comment' => $comment->comment,
        ]], 201);
    }
} 