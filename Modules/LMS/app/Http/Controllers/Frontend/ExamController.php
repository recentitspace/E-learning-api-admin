<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Exam\ExamRepository;

class ExamController extends Controller
{
    public function examStart($type, $exam_type_id, $courseId, Request $request)
    {


        $result = ExamRepository::startExam($type, $exam_type_id, $courseId, $request);

        if ($result['status'] != 'success') {
            return redirect()->route('home.index');
        }
        if ($type == "assignment") {
            $data = $result['data'];
            return view('theme::exam.assignment.index', compact('data', 'type', 'exam_type_id'));
        } elseif ($type == "quiz") {
            $data = $result['data'];
            $again = isset($request->status) && $request->status === 'try';
            $start = isset($request->status) && $request->status === 'start';
            return view('theme::exam.quiz.index', compact('data', 'type', 'exam_type_id', 'start', 'again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $exam = ExamRepository::save($request);
        if ($exam['status'] == 'success') {
            return response()->json(['status' => $exam['status'], 'type' => true]);
        }
    }
}
