<?php

namespace Modules\LMS\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Models\Courses\Review;
use Modules\LMS\Repositories\Review\ReviewRepository;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = ReviewRepository::paginate(
            15,
            options: [
                'where' => ['user_id',  authCheck()->id]
            ],
            relations: ['course' => function ($query) {
                $query->select('id', 'title', 'organization_id', 'slug');
                $query->with('instructors');
            }, 'user.userable' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'profile_img');
            }]
        );
        $reviews = $response['data'] ?? [];
        return view('portal::student.review.course.index', compact('reviews'));
    }
    /**
     *  create
     *
     *
     * @return View
     */
    public function create()
    {
        $review = $response['data'] ?? [];
        return view('portal::student.review.course.form', compact('review'));
    }
    /**
     * Method store
     *
     * @param Request $request
     *
     * @return array|JsonResponse
     */
    public function store(Request $request): array|JsonResponse
    {
        $checkReview =  Review::where(['user_id' => authCheck()->id, 'course_id' => $request->course_id])->first();
        if ($checkReview) {
            return [
                'status' => 'error',
                'message' => 'Already you have given the review this course'
            ];
        }
        $request->merge(['user_id' => authCheck()->id]);
        $response = ReviewRepository::save($request->all());
        if ($response['status'] !== 'success') {
            return $response;
        }
        return $this->jsonSuccess('Course review save successfully!', route('student.course-review.index'));
    }
}
