<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\LMS\Http\Requests\CourseRequest;
use Modules\LMS\Repositories\Courses\CourseRepository;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected CourseRepository $course) {}

    public function index(Request $request)
    {
        // Force JSON response if requested via API or Accept header
        if ($request->wantsJson() || $request->expectsJson() || $request->header('Accept') === 'application/json') {
            $request->headers->set('Accept', 'application/json');
        }

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

        $reports = $this->course->courseReport();
        $courses = $this->course->dashboardCourseFilter($request, options: $options);

        $countResponse = $this->course->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        // Return JSON if requested
        if ($request->wantsJson() || $request->expectsJson() || $request->header('Accept') === 'application/json') {
            // Helper function to format a single course
            $formatCourse = function ($course) {
                // Resolve thumbnail URL using helper function for consistency
                $thumbUrl = getThumbnailUrl($course->thumbnail ?? null, 'lms/courses/thumbnails');

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'thumbnail' => $thumbUrl,
                    'status' => $course->status,
                    'category' => $course->category ? [
                        'id' => $course->category->id,
                        'title' => $course->category->title ?? $course->category->name ?? null,
                    ] : null,
                    'price' => $course->coursePrice->price ?? null,
                    'discount_price' => $course->coursePrice->discount_price ?? null,
                    'currency' => $course->coursePrice->currency ?? null,
                    'instructors' => $course->instructors->map(function ($i) {
                        return [
                            'id' => $i->id,
                            'name' => trim(($i->userable->first_name ?? '').' '.($i->userable->last_name ?? '')) ?: ($i->name ?? null),
                        ];
                    })->values(),
                    'students_count' => $course->purchases()->count(),
                    'created_at' => $course->created_at?->toISOString(),
                    'updated_at' => $course->updated_at?->toISOString(),
                ];
            };

            // Handle paginated or collection results
            if (method_exists($courses, 'items')) {
                // Paginated result
                $formattedCourses = collect($courses->items())->map($formatCourse)->values();
                $pagination = [
                    'current_page' => $courses->currentPage(),
                    'last_page' => $courses->lastPage(),
                    'per_page' => $courses->perPage(),
                    'total' => $courses->total(),
                ];
            } else {
                // Collection result
                $formattedCourses = collect($courses)->map($formatCourse)->values();
                $pagination = null;
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'courses' => $formattedCourses,
                    'reports' => $reports,
                    'counts' => $countData,
                    'pagination' => $pagination,
                ]
            ], 200, [
                'Content-Type' => 'application/json; charset=utf-8'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // Return HTML view for browser requests
        return view('portal::admin.course.index', compact('courses', 'reports', 'countData'));
    }

    /**
     *  create
     */
    public function create(): View
    {
        return view('portal::admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        // Force JSON response
        $request->headers->set('Accept', 'application/json');
        
        // Enhanced logging for debugging
        \Log::info('Course store request received', [
            'has_file' => $request->hasFile('thumbnail'),
            'has_thumbnail_param' => $request->has('thumbnail'),
            'form_key' => $request->form_key,
            'course_id' => $request->course_id,
            'thumbnail_type' => $request->has('thumbnail') ? gettype($request->thumbnail) : 'N/A',
            'thumbnail_length' => $request->has('thumbnail') && is_string($request->thumbnail) ? strlen($request->thumbnail) : 0
        ]);
        
        try {
        if (!has_permissions($request->user(), ['add.course', 'edit.course'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have no permission.'
                ], 403);
        }
            
        $course = $this->course->store($request);

        $courseId = $course['course_id'] ?? '';
            
            \Log::info('Course store completed', [
                'course_id' => $courseId,
                'store_status' => $course['status'] ?? 'unknown'
            ]);
            
            // Get updated course data with thumbnail
            if ($courseId) {
                // Force refresh from database to get latest data
                $courseResponse = $this->course->first($courseId);
                if ($courseResponse['status'] === 'success' && $courseResponse['data']) {
                    $courseData = $courseResponse['data'];
                    
                    // Force refresh the model to ensure we have latest data
                    if (method_exists($courseData, 'refresh')) {
                        $courseData->refresh();
                    }
                    
                    \Log::info('Course data retrieved for response', [
                        'course_id' => $courseId,
                        'thumbnail_in_db' => $courseData->thumbnail ?? 'NULL',
                        'updated_at' => $courseData->updated_at?->toISOString()
                    ]);
                    
                    // Get thumbnail URL using helper (already includes cache busting)
                    $thumbnailUrl = getThumbnailUrl($courseData->thumbnail ?? null, 'lms/courses/thumbnails');
                    // Note: getThumbnailUrl already adds cache busting, so no need to add again
                    
                    // Check if file actually exists
                    $fileExists = false;
                    if ($courseData->thumbnail) {
                        $filePath = 'Modules/LMS/storage/app/public/lms/courses/thumbnails/' . $courseData->thumbnail;
                        $fileExists = file_exists(base_path($filePath));
                        \Log::info('Thumbnail file check', [
                            'filename' => $courseData->thumbnail,
                            'file_exists' => $fileExists,
                            'file_path' => $filePath
                        ]);
                    }
                    
                    // Add course data to response
                    $course['course'] = [
                        'id' => $courseData->id,
                        'title' => $courseData->title,
                        'slug' => $courseData->slug,
                        'thumbnail' => $thumbnailUrl,
                        'thumbnail_filename' => $courseData->thumbnail,
                        'file_exists' => $fileExists, // Debug info
                        'status' => $courseData->status,
                        'updated_at' => $courseData->updated_at?->toISOString(),
                    ];
                    
                    \Log::info('Course store response prepared', [
                        'course_id' => $courseId,
                        'thumbnail_filename' => $courseData->thumbnail,
                        'thumbnail_url' => $thumbnailUrl,
                        'file_exists' => $fileExists
                    ]);
                } else {
                    \Log::warning('Could not retrieve course data for response', [
                        'course_id' => $courseId,
                        'response_status' => $courseResponse['status'] ?? 'unknown'
                    ]);
                }
            }
            
        if (empty($request->course_id)) {
            $course['url'] = route('course.edit', $courseId);
        }
        $course['message'] = translate("Update Successfully");
            
            return response()->json($course, 200, [
                'Content-Type' => 'application/json; charset=utf-8'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            \Log::error('Course store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'form_key' => $request->form_key ?? 'N/A',
                'course_id' => $request->course_id ?? 'N/A'
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ], 500, [
                'Content-Type' => 'application/json; charset=utf-8'
            ]);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $course = $this->course->first($id, relations: ['courseTags']);
        return response()->json($course);
    }

    /**
     * Edit the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has the required permission to edit a course.

        if (!has_permissions($request->user(), ['edit.course'])) {
            toastr()->error('You have no permission.');
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();

        $course = $this->course->first(
            $id,
            relations: [
                'levels',
                'instructors.userable',
                'languages',
                'courseTags',
                'courseRequirements',
                'courseOutComes',
                'courseFaqs',
                'coursePrice',
                'courseSetting',
                'coursePreviews',
                'chapters.topics.topicable.topic_type',
                'courseNotes',
                'meetProvider',
                'organization',
                'category',
                'subject',
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale);
                }
            ]
        );

        return $course['status'] === 'success'
            ? view('portal::admin.course.edit', ['course' => $course['data']])
            : view('portal::admin.404');
    }

    /**
     * Edit the specified resource.
     */
    public function translate($id, Request $request)
    {
        // Check if the user has the required permission to edit a course.

        if (!has_permissions($request->user(), ['edit.course'])) {
            toastr()->error('You have no permission.');
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();

        $course = $this->course->first(
            $id,
            relations: [
                'levels',
                'instructors.userable',
                'languages',
                'courseTags',
                'courseRequirements',
                'courseOutComes',
                'courseFaqs',
                'coursePrice',
                'courseSetting',
                'coursePreviews',
                'chapters.topics.topicable.topic_type',
                'courseNotes',
                'meetProvider',
                'organization',
                'category',
                'subject',
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale);
                }
            ]
        );

        return $course['status'] === 'success'
            ? view('portal::admin.course.translate', ['course' => $course['data']])
            : view('portal::admin.404');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has the required permission to edit a course.
        if (!has_permissions($request->user(), ['delete.course'])) {
            // If not, return an error response.
            return json_error('You have no permission.');
        }
        // Update the course with the provided data.
        $response = $this->course->delete(id: $id, data: ['status' => 'Pending']);
        $response['url'] = route('course.index');
        // Return the result of the update operation as a JSON response.
        return response()->json($response);
    }

    /**
     * tagSearch
     */
    public function tagSearch(Request $request)
    {
        if ($request->q && $request->q != '') {
            $tags = $this->course->tagSearch($request);

            return response()->json($tags);
        }
    }
    /**
     * deleteInformation
     */
    public function deleteInformation(Request $request): JsonResponse
    {
        $result = $this->course->deleteInformation($request);
        return response()->json($result);
    }
    /**
     * deleteImage
     *
     * @param  $id  $id
     */
    public function deleteImage($id): JsonResponse
    {
        $result = $this->course->deleteImage($id);
        return response()->json($result);
    }
    /**
     *  statusChange
     *
     * @param  $id  $id
     * @param  mixed  $request
     */
    public function statusChange($id, Request $request)
    {
        // Check if the user has the required permission to edit a course.
        if (!has_permissions($request->user(), ['status.course'])) {
            // If not, return an error response.
            return json_error('You have no permission.');
        }
        $result = $this->course->statusChange($id, $request);
        toastr()->success(translate('Course Status Change Successfully'));
        return response()->json($result);
    }
    /**
     *  liveClass
     */
    public function liveClass()
    {
        $courses = $this->course->getLiveClass();
        return view('portal::admin.course.live-class', compact('courses'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a category
        if (!has_permissions($request->user(), ['delete.course'])) {
            return json_error('You have no permission.');
        }
        $response = $this->course->restore(id: $id);
        $response['url'] = route('course.index');
        return response()->json($response);
    }
}
