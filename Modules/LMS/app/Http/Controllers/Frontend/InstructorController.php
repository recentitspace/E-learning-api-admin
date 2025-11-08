<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\UserRepository;

class InstructorController extends Controller
{
    public function __construct(protected UserRepository $user) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->merge(['guard' => 'instructor']);
        $instructors = $this->user->instructorList($request, item: 9);
        if ($request->ajax()) {
            $result = view('theme::instructor.instructor-list', compact('instructors'))->render();
            return response()->json(
                [
                    'status' => true,
                    'data' => $result,
                    'total' => $instructors->total(),
                    'first_item' => $instructors->firstItem(),
                    'last_item' => $instructors->lastItem(),
                ]
            );
        }
        return view('theme::instructor.index', compact('instructors'));
    }
}
