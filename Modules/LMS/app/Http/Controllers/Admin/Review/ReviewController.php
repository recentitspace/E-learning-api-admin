<?php

namespace Modules\LMS\Http\Controllers\Admin\Review;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Enums\CourseStatus;
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
            relations: ['user.userable' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'profile_img');
            }],
            options: [
                'whereHas' => ['course', function ($query) {
                    $query->where('status', CourseStatus::APPROVED);
                    $query->select('id', 'title', 'organization_id', 'slug', 'status');
                    $query->with('instructors');
                }]
            ]
        );
        $reviews = $response['data'] ?? [];
        return view('portal::admin.review.course.index', compact('reviews'));
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
        return view('portal::admin.review.course.form', compact('review'));
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
        if (!has_permissions($request->user(), ['update.review'])) {
            return json_error('You have no permission.');
        }
        $response = ReviewRepository::update($id, $request->all());
        if ($response['status'] !== 'success') {
            return $response;
        }
        return $this->jsonSuccess('Course review modify successfully!', route('course-review.index'));
    }

    /**
     * Remove the specified Review from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete a Review.
        if (!has_permissions($request->user(), ['delete.review'])) {
            return json_error('You have no permission.');
        }
        // Attempt to delete the Review.
        $response = ReviewRepository::delete(id: $id);
        $response['url'] = route('course-review.index');
        return response()->json($response);
    }
}
