<?php

namespace Modules\LMS\Http\Controllers\Instructor;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Review\ReviewRepository;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $coursesId = authCheck()?->courses?->pluck('id')->toArray() ?? [];

        $response = ReviewRepository::paginate(
            15,
            options: [
                'whereIn' => ['course_id',  $coursesId]
            ],
            relations: ['course' => function ($query) {
                $query->select('id', 'title', 'organization_id', 'slug');
                $query->with('instructors');
            }, 'user.userable' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'profile_img');
            }]
        );
        $reviews = $response['data'] ?? [];
        return view('portal::instructor.review.course.index', compact('reviews'));
    }
    /**
     *  edit
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $response = ReviewRepository::first($id, relations: ['course' => function ($query) {
            $query->select('id', 'title', 'organization_id', 'slug');
            $query->with('instructors');
        }, 'user.userable' => function ($query) {
            $query->select('id', 'first_name', 'last_name', 'profile_img');
        }]);
        $review = $response['data'] ?? [];
        return view('portal::instructor.review.course.form', compact('review'));
    }

    /**
     * Method update
     *
     * @param int $id
     * @param Request $request
     *
     * @return array|JsonResponse
     */
    public function update($id, Request $request): array|JsonResponse
    {
        $response = ReviewRepository::update($id, $request->all());
        if ($response['status'] !== 'success') {
            return $response;
        }
        return $this->jsonSuccess('Course review modify successfully!', route('instructor.course-review.index'));
    }

    /**
     * Remove the specified Review from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {

        // Attempt to delete the Review.
        $response = ReviewRepository::delete(id: $id);
        $response['url'] = route('instructor.course-review.index');
        return response()->json($response);
    }
}
