<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\LMS\Models\Category;

class CategoryController extends Controller
{
    /**
     * List categories as JSON (public endpoint).
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;
        $page = (int) $request->query('page', 1);
        $search = trim((string) $request->query('search', ''));
        $parentId = $request->query('parent_id');
        $locale = $request->query('locale');

        $query = Category::query();

        // Only active categories if a status column exists in schema; otherwise this is harmless
        if (Category::query()->getModel()->isFillable('status') || \Schema::hasColumn((new Category)->getTable(), 'status')) {
            $query->where('status', 1);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('meta_title', 'like', "%{$search}%");
            });
        }

        if (!is_null($parentId) && $parentId !== '') {
            $query->where('parent_id', $parentId);
        }

        // Always include courses_count to avoid N+1 when clients need it
        $query->withCount('courses');

        if ($locale) {
            $query->with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }]);
        }

        $paginator = $query->orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (Category $category) use ($locale) {
            $translation = null;
            if ($locale && $category->relationLoaded('translations')) {
                $translation = $category->translations->first();
            }

            $title = $translation->title ?? $translation->name ?? $category->title ?? $category->name ?? null;
            $image = $category->image ?? null;
            $imageUrl = $image ? asset('storage/lms/categories/' . $image) : null;

            return [
                'id' => $category->id,
                'title' => $title,
                'slug' => $category->slug ?? null,
                'parent_id' => $category->parent_id ?? null,
                'icon_id' => $category->icon_id ?? null,
                'order' => $category->order ?? null,
                'status' => $category->status ?? null,
                'image' => $image,
                'image_url' => $imageUrl,
                'meta_title' => $translation->meta_title ?? $category->meta_title ?? null,
                'meta_description' => $translation->meta_description ?? $category->meta_description ?? null,
                // Correctly read dynamic attribute; fallback to relation count if not set
                'courses_count' => isset($category->courses_count) ? (int) $category->courses_count : (int) $category->courses()->count(),
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