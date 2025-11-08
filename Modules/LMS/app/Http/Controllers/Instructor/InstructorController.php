<?php

namespace Modules\LMS\Http\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Exam\ExamRepository;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\SearchSuggestionRepository;
use Modules\LMS\Repositories\Courses\Topics\TopicRepository;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizRepository;
use Modules\LMS\Repositories\Courses\Topics\Assignment\AssignmentRepository;

class InstructorController extends Controller
{
    public function __construct(
        protected SearchSuggestionRepository $suggestion,
        protected UserRepository $user,
        protected AssignmentRepository $assignment,
        protected ExamRepository $exam,
        protected TopicRepository $topic,
        protected CourseRepository $course,
        protected QuizRepository $quiz
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->user->dashboardInfoInstructor();
        return view('portal::instructor.index', compact('data'));
    }

    /**
     * searchingSuggestion
     *
     * @param  mixed  $request
     */
    public function searchingSuggestion(Request $request)
    {
        $results = $this->suggestion->searchSuggestion($request);
        return response()->json($results);
    }

    /**
     * logout
     */
    public function logout()
    {
        $user = Auth::user();
        
        // Revoke all tokens
        if ($user) {
            $user->tokens()->delete();
        }
        
        Auth::logout();
        \Illuminate\Support\Facades\Session::flush();
        
        // Clear cookies
        $response = redirect('/');
        $response->cookie(\Illuminate\Support\Facades\Cookie::forget('auth_token'));
        $response->cookie(\Illuminate\Support\Facades\Cookie::forget('user_info'));
        
        return $response;
    }

    /**
     * students
     */
    public function students()
    {
        $students = $this->user->enrolledStudents();
        return view('portal::instructor.student.student-list', compact('students'));
    }

    /**
     *  View Student Profile.
     */
    public function profile($id)
    {
        $user = $this->user->studentProfileView($id);

        return view('portal::admin.student.profile', compact('user'));
    }

    /**
     * courseAssignments
     */
    public function courseAssignments(Request $request)
    {
        $request = $request->merge(['instructors' => [authCheck()->id]]);
        $assignments = $this->topic->getTopicByCourse(coursesId: $this->course->getCoursesId($request), type: 'assignment', item: 10);
        return view('portal::instructor.assignment.index', compact('assignments'));
    }

    /**
     * Method studentAssignments
     *
     * @param  int  $assignmentId
     */
    public function studentAssignments($assignmentId)
    {
        $assignment = $this->assignment->first($assignmentId, relations: ['userAssignments']);
        $studentAssignments = $assignment['data'] ? $assignment['data']->userAssignments()->paginate(10) : null;
        $assignment = $assignment['data'];

        return view('portal::instructor.assignment.student-assignment', compact('assignment', 'studentAssignments'));
    }

    /**
     *  assignmentMark
     *
     * @param  int  $id
     */
    public function assignmentMark($id, Request $request)
    {
        $result = $this->exam->scoreUpdate($id, $request);
        if ($result['status'] !== 'success') {
            return $result;
        }
        return response()->json([
            'status' => $result['status'],
            'url' => route('instructor.assignments')
        ]);
    }

    public function wishlists()
    {
        $response =  UserRepository::wishlist();
        $wishlists = $response['data'] ?? [];
        return view('portal::instructor.wishlist.index', compact('wishlists'));
    }
    public function removeWishlist($id)
    {
        $response =  UserRepository::removeWishlist($id);
        $response['url'] = route('instructor.wishlist');
        return  response()->json($response);
    }
}
