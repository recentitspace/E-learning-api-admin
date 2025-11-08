<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\LMS\Enums\TopicTypes;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;
use Modules\LMS\Repositories\Courses\Topics\TopicRepository;

class CourseController extends Controller
{
    public function __construct(protected CourseRepository $course) {}

    /**
     * Display a listing of the resource.
     */
    public function courseList(Request $request)
    {
        $courses = $this->course->courseList($request);

       
        if ($request->ajax()) {
            $result = view('theme::course.ajax-course-list', compact('courses'))->render();
            return response()->json(
                [
                    'status' => true,
                    'data' => $result,
                    'total' => $courses->total(),
                    'first_item' => $courses->firstItem(),
                    'last_item' => $courses->lastItem(),
                ]
            );
        }

        return view('theme::course.course-list', compact('courses'));
    }

    /**
     * courseDetail
     *
     * @param  string  $slug
     */
    public function courseDetail($slug)
    {
        $course = $this->course->courseDetail($slug);
        $hasPurchase =  $course->hasUserPurchased(user: null);
        $request = Request()->merge([
            'course_id' => $course->id,
            'categories' => $course->category_id
        ]);
        $relatedCourses =  $this->course->courseList($request);
        return view('theme::course.course-detail', compact('course', 'relatedCourses', 'hasPurchase'));
    }

    /**
     * courseBundleDetail
     *
     * @param  string  $slug
     */
    public function courseBundleDetail($slug)
    {
        $bundle = $this->course->courseBundleDetail($slug);
        return view('theme::course.bundle', compact('bundles'));
    }
    /**
     * courseVideoPlayer
     *
     * @param  string  $slug
     */
    public function courseVideoPlayer($slug, Request $request)
    {
        $course = $this->course->courseDetail($slug);
        $purchase = PurchaseRepository::getByUserId([
            'user_id' => authCheck()->id,
            'course_id' => $course->id
        ]);

        $data = [
            'type' => $request->type ?? null,
            'topic_id' => $request->topic_id ?? null,
            'chapter_id' => $request->chapter_id ?? null,
        ];

        $assignments = TopicRepository::getTopicByCourse($course->id,  TopicTypes::ASSIGNMENT);

        if (!$purchase  && isStudent()) {
            return redirect()->back();
        }
        return view('theme::course.course-video', compact('course', 'assignments', 'data'));
    }
    /**
     *  leanCourseTopic
     */
    public function leanCourseTopic(Request $request)
    {
        return $this->course->getCourseTopicByType($request);
    }
    /**
     * Review
     */
    public function review(Request $request)
    {
        return $this->course->review($request);
    }
}
