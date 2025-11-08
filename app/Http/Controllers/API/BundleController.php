<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;

class BundleController extends Controller
{
    /**
     * Public: list bundles with pagination and filters.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;
        $page = (int) $request->query('page', 1);
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category_id');
        $locale = $request->query('locale');

        $query = CourseBundle::query()->with(['category', 'courses', 'levels'])->whereNull('deleted_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        if (!is_null($categoryId) && $categoryId !== '') {
            $query->where('category_id', $categoryId);
        }
        if ($locale) {
            $query->with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }]);
        }

        $paginator = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (CourseBundle $bundle) use ($locale) {
            $translation = null;
            if ($locale && $bundle->relationLoaded('translations')) {
                $translation = $bundle->translations->first();
            }
            $title = $translation->title ?? $bundle->title ?? $bundle->name ?? null;
            $short = $translation->short_description ?? $bundle->short_description ?? null;

            return [
                'id' => $bundle->id,
                'title' => $title,
                'slug' => $bundle->slug ?? Str::slug((string) $title),
                'category' => $bundle->category ? [
                    'id' => $bundle->category->id,
                    'title' => $bundle->category->title ?? $bundle->category->name ?? null,
                ] : null,
                'price' => $bundle->price ?? null,
                'platform_fee' => $bundle->platform_fee ?? null,
                'discount_price' => $bundle->discount_price ?? null,
                'thumbnail' => $bundle->thumbnail ?? null,
                'short_description' => $short,
                'courses_count' => $bundle->courses->count(),
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

    /**
     * Public: bundle detail by id or slug.
     */
    public function show($bundle): JsonResponse
    {
        $locale = request()->query('locale');
        $query = CourseBundle::query()
            ->with(['category', 'courses.coursePrice', 'courses.instructors', 'levels', 'bundleFaqs'])
            ->whereNull('deleted_at');

        $model = is_numeric($bundle)
            ? $query->find($bundle)
            : $query->where('slug', $bundle)->first();

        if (!$model) {
            return response()->json(['status' => 'error', 'message' => 'Bundle not found'], 404);
        }

        $translation = null;
        if ($locale) {
            $model->load(['translations' => function ($q) use ($locale) { $q->where('locale', $locale); }]);
            $translation = $model->translations->first();
        }

        $title = $translation->title ?? $model->title ?? $model->name ?? null;
        $description = $translation->description ?? $model->description ?? null;

        $data = [
            'id' => $model->id,
            'title' => $title,
            'slug' => $model->slug ?? Str::slug((string) $title),
            'description' => $description,
            'category' => $model->category ? [
                'id' => $model->category->id,
                'title' => $model->category->title ?? $model->category->name ?? null,
            ] : null,
            'price' => $model->price ?? null,
            'platform_fee' => $model->platform_fee ?? null,
            'discount_price' => $model->discount_price ?? null,
            'thumbnail' => $model->thumbnail ?? null,
            'levels' => $model->levels->map(fn($l) => ['id' => $l->id, 'name' => $l->name ?? $l->title ?? null])->values(),
            'faqs' => $model->bundleFaqs->map(fn($f) => ['id' => $f->id, 'question' => $f->question ?? null, 'answer' => $f->answer ?? null])->values(),
            'courses' => $model->courses->map(function ($c) {
                return [
                    'id' => $c->id,
                    'title' => $c->title ?? $c->name ?? null,
                    'price' => $c->coursePrice->price ?? null,
                    'discount_price' => $c->coursePrice->discount_price ?? null,
                    'instructors' => $c->instructors->map(function ($i) {
                        return [
                            'id' => $i->id,
                            'name' => trim(($i->userable->first_name ?? '').' '.($i->userable->last_name ?? '')) ?: ($i->name ?? null),
                        ];
                    })->values(),
                ];
            })->values(),
        ];

        return response()->json(['status' => 'success', 'data' => $data]);
    }
} 