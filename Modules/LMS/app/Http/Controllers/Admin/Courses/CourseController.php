<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        if (!has_permissions($request->user(), ['add.course', 'edit.course'])) {
            return json_error('You have no permission.');
        }
        $course = $this->course->store($request);

        $courseId = $course['course_id'] ?? '';
        if (empty($request->course_id)) {
            $course['url'] = route('course.edit', $courseId);
        }
        $course['message'] = translate("Update Successfully");
        return response()->json($course);
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
