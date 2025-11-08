<?php

namespace Modules\LMS\Http\Controllers\Instructor\Courses;

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
        $request->merge(['instructors' => [authCheck()->id]]);

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
        $countResponse = $this->course->getCourseByUser(request: $request->merge(['instructors' => [authCheck()->id]]));

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }
        return view('portal::instructor.course.index', compact('courses', 'countData'));
    }

    /**
     *  create
     */
    public function create(): View
    {
        return view('portal::instructor.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $course = $this->course->store($request);
        $courseId = $course['course_id'];
        if (empty($request->course_id)) {
            $course['url'] = route('instructor.course.edit', $courseId);
        }
        $course['message'] = translate('Update Successfully');
        return response()->json($course);
    }

    /**
     * Edit the specified resource.
     */
    public function edit($id)
    {
        $response = $this->course->getFirst($id);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $course = $response['data'] ?? null;
        return view('portal::instructor.course.edit', compact('course'));
    }


    /**
     * Edit the specified resource.
     */
    public function translate($id, Request $request)
    {

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
            ? view('portal::instructor.course.translate', ['course' => $course['data']])
            : view('portal::admin.404');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        // Update the course with the provided data.
        $response = $this->course->delete(id: $id, data: ['status' => 'Pending']);
        $response['url'] = route('instructor.course.index');
        // Return the result of the update operation as a JSON response.
        return response()->json($response);
    }

    /**
     *  requirementGetByQuery
     */
    public function requirementGetByQuery(Request $request)
    {
        $requirements = $this->course->requirementSearch($request);

        if ($requirements) {
            $output = '<ul class="search-data dropdown-menu" style="display:block; position:relative">';
            foreach ($requirements as $requirement) {
                $output .= '<li><a href="#">' . $requirement->title . '</a></li>';
            }
            $output .= '</ul>';

            return response()->json($output);
        }
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
     * restore the specified course from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id)
    {
        $response = $this->course->restore(id: $id);
        $response['url'] = route('instructor.course.index');
        return response()->json($response);
    }
}
