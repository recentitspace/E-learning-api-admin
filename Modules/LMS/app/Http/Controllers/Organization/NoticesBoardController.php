<?php

namespace Modules\LMS\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\NoticesBoardRepository;

class NoticesBoardController extends Controller
{
    public function __construct(protected NoticesBoardRepository $notices, protected UserRepository $user, protected CourseRepository $course) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticesBoards = $this->notices->noticesGetByUser(item: 10);

        return view('portal::organization.notices-board.index', compact('noticesBoards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request = $request->merge(['organizations' => [authCheck()->id]]);
        $courses = $this->user->purchaseCourse($this->course->getCoursesId($request));

        return view('portal::organization.notices-board.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $result = $this->notices->save($request);
        if ($result['status'] !== 'success') {
            return response()->json($result);
        }
        return response()->json([
            'status' => $result['status'],
            'url' => route('organization.noticeboard.index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        $response = $this->notices->first($id);
        $request = $request->merge(['organizations' => [authCheck()->id]]);
        $courses = $this->user->purchaseCourse($this->course->getCoursesId($request));
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $notice = $response['data'];
        return view('portal::organization.notices-board.create', compact('courses', 'notice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->notices->delete($id);
    }
}
