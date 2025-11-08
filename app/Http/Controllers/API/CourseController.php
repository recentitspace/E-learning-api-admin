<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\Courses\CoursePrice;
use Modules\LMS\Models\Auth\Instructor as InstructorModel;

class CourseController extends Controller
{
    /**
     * Public: list courses for cards (no filters), JSON only.
     */
    public function index(Request $request): JsonResponse
    {
        $locale = $request->query('locale');

        $items = Course::query()
            ->with(['coursePrice', 'category', 'instructors', 'levels', 'chapters', 'courseSetting'])
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->limit(36)
            ->get();

        $data = $items->map(function (Course $course) use ($locale) {
            $translation = null;
            if ($locale && $course->relationLoaded('translations')) {
                $translation = $course->translations->first();
            }
            $title = $translation->title ?? $course->title ?? $course->name ?? null;
            $short = $translation->short_description ?? $course->short_description ?? null;

            $firstLevel = $course->levels->first();
            $primaryLevel = $firstLevel ? ($firstLevel->name ?? $firstLevel->title ?? null) : null;
            $sectionsCount = $course->chapters ? $course->chapters->count() : $course->chapters()->count();
            $studentsCount = $course->purchases()->count();
            $hours = $course->courseSetting ? ($course->courseSetting->duration ?? $course->courseSetting->hours ?? null) : null;

            // Resolve thumbnail URL safely
            $thumb = $course->thumbnail ?? null;
            $thumbUrl = null;
            if ($thumb) {
                $t = (string) $thumb;
                if (Str::startsWith($t, ['http://', 'https://'])) {
                    $thumbUrl = $t;
                } elseif (Str::startsWith($t, ['/'])) {
                    $thumbUrl = asset(ltrim($t, '/'));
                } elseif (Str::startsWith($t, ['storage/', 'lms/'])) {
                    $t = ltrim($t, '/');
                    $thumbUrl = Str::startsWith($t, 'storage/') ? asset($t) : asset('storage/'.$t);
                } else {
                    $thumbUrl = asset('storage/lms/courses/thumbnails/'.$t);
                }
            }

            return [
                'id' => $course->id,
                'title' => $title,
                'slug' => $course->slug ?? Str::slug((string) $title),
                'category' => $course->category ? [
                    'id' => $course->category->id,
                    'title' => $course->category->title ?? $course->category->name ?? null,
                ] : null,
                'levels' => $course->levels->map(fn($l) => ['id' => $l->id, 'name' => $l->name ?? $l->title ?? null])->values(),
                'level' => $primaryLevel,
                'price' => $course->coursePrice->price ?? null,
                'platform_fee' => $course->coursePrice->platform_fee ?? null,
                'discount_price' => $course->coursePrice->discount_price ?? null,
                'thumbnail' => $thumbUrl ?? $course->thumbnail ?? null,
                'short_description' => $short,
                'students_count' => (int) $studentsCount,
                'sections_count' => (int) $sectionsCount,
                'hours' => $hours,
                'instructors' => $course->instructors->map(function ($i) {
                    return [
                        'id' => $i->id,
                        'name' => trim(($i->userable->first_name ?? '').' '.($i->userable->last_name ?? '')) ?: ($i->name ?? null),
                    ];
                })->values(),
            ];
        })->values();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Public: course detail by id or slug; JSON only.
     */
    public function show($course): JsonResponse
    {
        $locale = request()->query('locale');
        $query = Course::query()
            ->with([
                'coursePrice',
                'category',
                'instructors',
                'courseOutComes',
                'courseRequirements',
                'courseFaqs',
                'coursePreviews',
                'levels',
                'chapters.topics.topicable',
                'courseSetting',
            ])
            ->whereNull('deleted_at');

        $model = is_numeric($course)
            ? $query->find($course)
            : $query->where('slug', $course)->first();

        if (!$model) {
            return response()->json(['status' => 'error', 'message' => 'Course not found'], 404);
        }

        $translation = null;
        if ($locale) {
            $model->load(['translations' => function ($q) use ($locale) { $q->where('locale', $locale); }]);
            $translation = $model->translations->first();
        }

        $title = $translation->title ?? $model->title ?? $model->name ?? null;
        $description = $translation->description ?? $model->description ?? null;

        // Resolve thumbnail URL safely
        $thumb = $model->thumbnail ?? null;
        $thumbUrl = null;
        if ($thumb) {
            $t = (string) $thumb;
            if (Str::startsWith($t, ['http://', 'https://'])) {
                $thumbUrl = $t;
            } elseif (Str::startsWith($t, ['/'])) {
                $thumbUrl = asset(ltrim($t, '/'));
            } elseif (Str::startsWith($t, ['storage/', 'lms/'])) {
                $t = ltrim($t, '/');
                $thumbUrl = Str::startsWith($t, 'storage/') ? asset($t) : asset('storage/'.$t);
            } else {
                $thumbUrl = asset('storage/lms/courses/thumbnails/'.$t);
            }
        }

        $firstLevel = $model->levels->first();
        $primaryLevel = $firstLevel ? ($firstLevel->name ?? $firstLevel->title ?? null) : null;
        $sectionsCount = $model->chapters ? $model->chapters->count() : $model->chapters()->count();
        $studentsCount = $model->purchases()->count();
        $hours = $model->courseSetting?->duration ?? $model->duration ?? null;
        $isCertificate = (int) ($model->courseSetting?->is_certificate ?? 0) === 1;
        $demoUrl = $model->demo_url ?? $model->short_video ?? null;

        $user = auth()->user();
        $isLoggedIn = auth()->check();
        $isEnrolled = method_exists($model, 'hasUserPurchased') ? (bool) $model->hasUserPurchased(user: $user) : false;

        $curriculum = $model->chapters->map(function ($ch) use ($isEnrolled) {
            return [
                'id' => $ch->id,
                'title' => $ch->title ?? ('Section '.$ch->id),
                'topics' => $ch->topics->map(function ($t) use ($isEnrolled) {
                    $type = class_basename($t->topicable_type ?? '') ?: null;
                    $videoUrl = null;
                    if ($type === 'Video' && $t->topicable) {
                        $raw = $t->topicable->video_url ?? $t->topicable->system_video ?? null;
                        if ($raw) {
                            $s = (string) $raw;
                            if (Str::startsWith($s, ['http://', 'https://'])) {
                                $videoUrl = $s;
                            } elseif (Str::startsWith($s, ['/'])) {
                                $videoUrl = asset(ltrim($s, '/'));
                            } else {
                                $videoUrl = asset('storage/'.$s);
                            }
                        }
                    }
                    $topicTitle = $t->title ?? ($t->topicable->title ?? null);
                    $topicDuration = $t->duration ?? ($t->topicable->duration ?? null);
                    return [
                        'id' => $t->id,
                        'title' => $topicTitle,
                        'duration' => $topicDuration,
                        'type' => $type,
                        'video_url' => $videoUrl,
                        'locked' => !$isEnrolled,
                    ];
                })->values(),
            ];
        })->values();

        $data = [
            'id' => $model->id,
            'title' => $title,
            'slug' => $model->slug ?? Str::slug((string) $title),
            'description' => $description,
            'category' => $model->category ? [
                'id' => $model->category->id,
                'title' => $model->category->title ?? $model->category->name ?? null,
            ] : null,
            'price' => $model->coursePrice->price ?? null,
            'platform_fee' => $model->coursePrice->platform_fee ?? null,
            'discount_price' => $model->coursePrice->discount_price ?? null,
            'thumbnail' => $thumbUrl ?? $model->thumbnail ?? null,
            'levels' => $model->levels->map(fn($l) => ['id' => $l->id, 'name' => $l->name ?? $l->title ?? null])->values(),
            'level' => $primaryLevel,
            'students_count' => (int) $studentsCount,
            'sections_count' => (int) $sectionsCount,
            'hours' => $hours,
            'is_certificate' => $isCertificate,
            'demo_url' => $demoUrl,
            'is_logged_in' => (bool) $isLoggedIn,
            'is_enrolled' => (bool) $isEnrolled,
            'previews' => $model->coursePreviews->map(function ($p) {
                return [
                    'id' => $p->id,
                    'image' => $p->image ?? null,
                ];
            })->values(),
            'outcomes' => $model->courseOutComes->map(fn($o) => ['id' => $o->id, 'name' => $o->name ?? $o->title ?? null])->values(),
            'requirements' => $model->courseRequirements->map(fn($r) => ['id' => $r->id, 'name' => $r->name ?? $r->title ?? null])->values(),
            'faqs' => $model->courseFaqs->map(fn($f) => ['id' => $f->id, 'question' => $f->question ?? null, 'answer' => $f->answer ?? null])->values(),
            'instructors' => $model->instructors->map(function ($i) {
                return [
                    'id' => $i->id,
                    'name' => trim(($i->userable->first_name ?? '').' '.($i->userable->last_name ?? '')) ?: ($i->name ?? null),
                ];
            })->values(),
            'curriculum' => $curriculum,
        ];

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Public: list courses by instructor with optional filters (category, level) and sorting (popular, price asc/desc)
     */
    public function byInstructor(Request $request, $instructorId): JsonResponse
    {
        $categoryId = $request->query('category_id');
        $levelId = $request->query('level_id'); // single or comma-separated
        $sort = $request->query('sort'); // popular | price_asc | price_desc
        $locale = $request->query('locale');

        // Resolve Instructor id to its user id for the course_instructors pivot
        $instructor = InstructorModel::with('user')->find($instructorId);
        if (!$instructor || !$instructor->user) {
            return response()->json(['status' => 'success', 'data' => []]);
        }
        $userId = $instructor->user->id;

        $query = Course::query()
            ->with(['coursePrice', 'category', 'instructors', 'levels', 'chapters', 'courseSetting'])
            ->whereNull('deleted_at')
            ->whereHas('instructors', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            });

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }
        if (!empty($levelId)) {
            $levelIds = collect(explode(',', (string) $levelId))->filter()->all();
            $query->whereHas('levels', function ($q) use ($levelIds) {
                $q->whereIn('levels.id', $levelIds);
            });
        }
        if ($locale) {
            $query->with(['translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }]);
        }

        if ($sort === 'price_asc' || $sort === 'price_desc') {
            $query->leftJoin('course_prices', 'course_prices.course_id', '=', 'courses.id')
                ->select('courses.*')
                ->orderBy('course_prices.price', $sort === 'price_asc' ? 'asc' : 'desc');
        } elseif ($sort === 'popular') {
            $query->saleCountNumber()->orderBy('sale_count_number', 'desc');
        } else {
            $query->orderBy('courses.id', 'desc');
        }

        $items = $query->limit(100)->get();

        $data = $items->map(function (Course $course) use ($locale) {
            $translation = null;
            if ($locale && $course->relationLoaded('translations')) {
                $translation = $course->translations->first();
            }
            $title = $translation->title ?? $course->title ?? $course->name ?? null;
            $short = $translation->short_description ?? $course->short_description ?? null;

            $firstLevel = $course->levels->first();
            $primaryLevel = $firstLevel ? ($firstLevel->name ?? $firstLevel->title ?? null) : null;
            $sectionsCount = $course->chapters ? $course->chapters->count() : $course->chapters()->count();
            $studentsCount = $course->purchases()->count();
            $hours = $course->courseSetting ? ($course->courseSetting->duration ?? $course->courseSetting->hours ?? null) : null;

            // Resolve thumbnail URL safely
            $thumb = $course->thumbnail ?? null;
            $thumbUrl = null;
            if ($thumb) {
                $t = (string) $thumb;
                if (Str::startsWith($t, ['http://', 'https://'])) {
                    $thumbUrl = $t;
                } elseif (Str::startsWith($t, ['/'])) {
                    $thumbUrl = asset(ltrim($t, '/'));
                } elseif (Str::startsWith($t, ['storage/', 'lms/'])) {
                    $t = ltrim($t, '/');
                    $thumbUrl = Str::startsWith($t, 'storage/') ? asset($t) : asset('storage/'.$t);
                } else {
                    $thumbUrl = asset('storage/lms/courses/thumbnails/'.$t);
                }
            }

            return [
                'id' => $course->id,
                'title' => $title,
                'slug' => $course->slug ?? Str::slug((string) $title),
                'category' => $course->category ? [
                    'id' => $course->category->id,
                    'title' => $course->category->title ?? $course->category->name ?? null,
                ] : null,
                'levels' => $course->levels->map(fn($l) => ['id' => $l->id, 'name' => $l->name ?? $l->title ?? null])->values(),
                'level' => $primaryLevel,
                'price' => $course->coursePrice->price ?? null,
                'platform_fee' => $course->coursePrice->platform_fee ?? null,
                'discount_price' => $course->coursePrice->discount_price ?? null,
                'thumbnail' => $thumbUrl ?? $course->thumbnail ?? null,
                'short_description' => $short,
                'students_count' => (int) $studentsCount,
                'sections_count' => (int) $sectionsCount,
                'hours' => $hours,
                'instructors' => $course->instructors->map(function ($i) {
                    return [
                        'id' => $i->id,
                        'name' => trim(($i->userable->first_name ?? '').' '.($i->userable->last_name ?? '')) ?: ($i->name ?? null),
                    ];
                })->values(),
            ];
        })->values();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    // Placeholders to avoid runtime errors for routes that reference these actions but are not implemented.
    public function store(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function update(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function destroy(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function uploadImage(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function enrolledCourses(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function enroll(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function addToWishlist(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
    public function removeFromWishlist(): JsonResponse { return response()->json(['status' => 'error', 'message' => 'Not implemented'], 501); }
} 