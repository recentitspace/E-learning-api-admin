<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Models\Enrollment;
use Modules\LMS\Models\Courses\Course;

class EnrollmentController extends Controller
{
    /**
     * Get enrolled courses for a student
     * GET /api/enrollments?student_id=41
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|integer|exists:users,id',
        ]);

        $locale = $request->query('locale');
        $studentId = $request->query('student_id');

        try {
            // Get all enrollments for the student
            $enrollments = Enrollment::where('student_id', $studentId)
                ->with(['course' => function ($query) {
                    $query->with([
                        'coursePrice',
                        'category',
                        'instructors.userable',
                        'courseOutComes',
                        'courseRequirements',
                        'courseFaqs',
                        'coursePreviews',
                        'levels',
                        'chapters.topics.topicable',
                        'courseSetting',
                    ])->whereNull('deleted_at');
                }])
                ->get();

            $data = $enrollments->map(function ($enrollment) use ($locale) {
                $course = $enrollment->course;
                
                if (!$course) {
                    return [
                        'enrollment_id' => $enrollment->id,
                        'student_id' => $enrollment->student_id,
                        'course_id' => $enrollment->course_id,
                        'course_title' => $enrollment->course_title,
                        'price' => $enrollment->price,
                        'status' => $enrollment->status,
                        'course_status' => $enrollment->course_status,
                        'course' => null,
                    ];
                }

                // Handle translations if locale is provided
                $translation = null;
                if ($locale) {
                    $course->load(['translations' => function ($q) use ($locale) {
                        $q->where('locale', $locale);
                    }]);
                    $translation = $course->translations->first();
                }

                $title = $translation->title ?? $course->title ?? $course->name ?? null;
                $description = $translation->description ?? $course->description ?? null;

                // Resolve thumbnail URL
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

                $firstLevel = $course->levels->first();
                $primaryLevel = $firstLevel ? ($firstLevel->name ?? $firstLevel->title ?? null) : null;
                $sectionsCount = $course->chapters ? $course->chapters->count() : $course->chapters()->count();
                $studentsCount = $course->purchases()->count();
                $hours = $course->courseSetting?->duration ?? $course->duration ?? null;
                $isCertificate = (int) ($course->courseSetting?->is_certificate ?? 0) === 1;
                $demoUrl = $course->demo_url ?? $course->short_video ?? null;

                // Build curriculum (lessons)
                $curriculum = $course->chapters->map(function ($ch) {
                    return [
                        'id' => $ch->id,
                        'title' => $ch->title ?? ('Section '.$ch->id),
                        'order' => $ch->order ?? null,
                        'topics' => $ch->topics->map(function ($t) {
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
                                'order' => $t->order ?? null,
                                'locked' => false, // Student is enrolled, so not locked
                            ];
                        })->values(),
                    ];
                })->values();

                return [
                    'enrollment_id' => $enrollment->id,
                    'student_id' => $enrollment->student_id,
                    'organization_id' => $enrollment->organization_id,
                    'enrollment_status' => $enrollment->status,
                    'course_status' => $enrollment->course_status,
                    'enrolled_at' => $enrollment->created_at,
                    'course' => [
                        'id' => $course->id,
                        'title' => $title,
                        'slug' => $course->slug ?? Str::slug((string) $title),
                        'description' => $description,
                        'short_description' => $translation->short_description ?? $course->short_description ?? null,
                        'category' => $course->category ? [
                            'id' => $course->category->id,
                            'title' => $course->category->title ?? $course->category->name ?? null,
                        ] : null,
                        'price' => $course->coursePrice->price ?? null,
                        'platform_fee' => $course->coursePrice->platform_fee ?? null,
                        'discount_price' => $course->coursePrice->discount_price ?? null,
                        'thumbnail' => $thumbUrl ?? $course->thumbnail ?? null,
                        'levels' => $course->levels->map(fn($l) => ['id' => $l->id, 'name' => $l->name ?? $l->title ?? null])->values(),
                        'level' => $primaryLevel,
                        'students_count' => (int) $studentsCount,
                        'sections_count' => (int) $sectionsCount,
                        'hours' => $hours,
                        'is_certificate' => $isCertificate,
                        'demo_url' => $demoUrl,
                        'previews' => $course->coursePreviews->map(function ($p) {
                            return [
                                'id' => $p->id,
                                'image' => $p->image ?? null,
                            ];
                        })->values(),
                        'outcomes' => $course->courseOutComes->map(fn($o) => ['id' => $o->id, 'name' => $o->name ?? $o->title ?? null])->values(),
                        'requirements' => $course->courseRequirements->map(fn($r) => ['id' => $r->id, 'name' => $r->name ?? $r->title ?? null])->values(),
                        'faqs' => $course->courseFaqs->map(fn($f) => ['id' => $f->id, 'question' => $f->question ?? null, 'answer' => $f->answer ?? null])->values(),
                        'instructors' => $course->instructors->map(function ($i) {
                            return [
                                'id' => $i->id,
                                'name' => trim(($i->userable->first_name ?? '').' '.($i->userable->last_name ?? '')) ?: ($i->name ?? null),
                            ];
                        })->values(),
                        'curriculum' => $curriculum, // Full lessons/chapters structure
                    ],
                ];
            })->values();

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'count' => $data->count(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage() ?? 'An error occurred while fetching enrollments',
            ], 500);
        }
    }

    /**
     * Create a new enrollment
     * POST /api/enrollments
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate request
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:users,id',
            'organization_id' => 'nullable|integer|exists:users,id',
            'course_id' => 'required|integer|exists:courses,id',
            'course_title' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
            'course_status' => 'nullable|string',
        ]);

        try {
            // Check if student is already enrolled in this course
            $existingEnrollment = Enrollment::where('student_id', $validated['student_id'])
                ->where('course_id', $validated['course_id'])
                ->first();

            if ($existingEnrollment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Already enrolled',
                    'data' => [
                        'id' => $existingEnrollment->id,
                        'student_id' => $existingEnrollment->student_id,
                        'course_id' => $existingEnrollment->course_id,
                        'course_title' => $existingEnrollment->course_title,
                        'status' => $existingEnrollment->status,
                        'course_status' => $existingEnrollment->course_status,
                    ],
                ], 409); // 409 Conflict status code
            }

            // Get course to verify it exists and get title if not provided
            $course = Course::findOrFail($validated['course_id']);
            
            // Use course title if not provided in request
            if (empty($validated['course_title'])) {
                $validated['course_title'] = $course->title ?? $course->name ?? 'Untitled Course';
            }

            // Map status: 'pending' -> 'paid', or default to 'free' if price is 0, 'paid' otherwise
            if (empty($validated['status'])) {
                $validated['status'] = ($validated['price'] ?? 0) > 0 ? 'paid' : 'free';
            } elseif ($validated['status'] === 'pending') {
                $validated['status'] = 'paid';
            } elseif (!in_array($validated['status'], ['free', 'paid'])) {
                // If status is not valid, default based on price
                $validated['status'] = ($validated['price'] ?? 0) > 0 ? 'paid' : 'free';
            }

            // Map course_status: 'active' -> 'processing', or default to 'processing'
            if (empty($validated['course_status'])) {
                $validated['course_status'] = 'processing';
            } elseif ($validated['course_status'] === 'active') {
                $validated['course_status'] = 'processing';
            } elseif (!in_array($validated['course_status'], ['processing', 'completed'])) {
                $validated['course_status'] = 'processing';
            }

            // Create enrollment (id will be auto-generated)
            $enrollment = Enrollment::create([
                'student_id' => $validated['student_id'],
                'organization_id' => $validated['organization_id'] ?? null,
                'course_id' => $validated['course_id'],
                'course_title' => $validated['course_title'],
                'price' => $validated['price'] ?? 0,
                'status' => $validated['status'],
                'course_status' => $validated['course_status'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Enrolled successfully',
                'data' => [
                    'id' => $enrollment->id,
                    'student_id' => $enrollment->student_id,
                    'course_id' => $enrollment->course_id,
                    'course_title' => $enrollment->course_title,
                    'status' => $enrollment->status,
                    'course_status' => $enrollment->course_status,
                ],
            ], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course or user not found',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage() ?? 'An error occurred during enrollment',
            ], 500);
        }
    }

    /**
     * Update an enrollment
     * PUT/PATCH /api/enrollments/{id}
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Validate request
        $validated = $request->validate([
            'course_status' => 'nullable|string|in:processing,completed,approved',
            'status' => 'nullable|string|in:free,paid',
            'price' => 'nullable|numeric|min:0',
        ]);

        try {
            $enrollment = Enrollment::findOrFail($id);

            // Update only provided fields
            if ($request->has('course_status')) {
                $enrollment->course_status = $validated['course_status'];
            }
            if ($request->has('status')) {
                $enrollment->status = $validated['status'];
            }
            if ($request->has('price')) {
                $enrollment->price = $validated['price'];
            }

            $enrollment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Enrollment updated successfully',
                'data' => [
                    'id' => $enrollment->id,
                    'student_id' => $enrollment->student_id,
                    'course_id' => $enrollment->course_id,
                    'course_title' => $enrollment->course_title,
                    'status' => $enrollment->status,
                    'course_status' => $enrollment->course_status,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Enrollment not found',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage() ?? 'An error occurred while updating enrollment',
            ], 500);
        }
    }
}

