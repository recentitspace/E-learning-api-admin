<?php

namespace Modules\LMS\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\SupportTicket\SupportRepository;

class SupportController extends Controller
{
    public function __construct(protected SupportRepository $support, protected CourseRepository $course) {}

    /**
     * index
     */
    public function index()
    {

        $tickets = $this->support->getSupports(10, type: 'platform');
        $coursesTickets = $this->support->getSupports(10, type: 'course');
        return view('portal::instructor.supports.index', compact('tickets', 'coursesTickets'));
    }

    /**
     * create
     */
    public function create(Request $request)
    {
        $request->merge(['instructors' => [authCheck()->id]]);
        $courses = $this->course->dashboardCourseFilter($request, null);

        return view('portal::instructor.supports.create', compact('courses'));
    }

    /**
     * creating a new resource.
     */
    public function reply($id, Request $request)
    {
        $ticket = $this->support->firstTicketById($id);
        $type = $request->type ?? '';
        return view('portal::instructor.supports.reply', compact('ticket', 'type'));
    }

    /**
     *  ticketReply
     *
     * @param  mixed  $request
     */
    public function ticketReply(Request $request)
    {
        $ticket = $this->support->ticketReply($request);
        if ($ticket['status'] !== 'success') {
            return  $ticket;
        }
        toastr()->success(translate('Ticket Reply Successfully'));
        return response()->json(['status' => 'success', 'type' => true]);
    }

    /**
     * deleteSupportFile
     *
     * @param  int  $id
     */
    public function deleteSupportFile($id)
    {
        return $this->support->deleteSupportFile($id);
    }

    /**
     * store
     *
     * @param  mixed  $request
     */
    public function store(Request $request)
    {
        $ticket = $this->support->save($request);
        if ($ticket['status'] !== 'success') {
            return $ticket;
        }
        toastr()->success(translate('Support has been saved successfully!'));
        return response()->json([
            'status' => 'success',
            'url' => $request->type == 'course' ? route('instructor.supports.index') : route('instructor.supports.index')
        ]);
    }

    public function studentSupport()
    {
        $tickets = $this->support->instructorStudentSupport();
        return view('portal::instructor.supports.student-support', compact('tickets'));
    }



    public function studentSupportReply($id, Request $request)
    {
        $ticket = $this->support->firstTicketById($id);
        $type = $request->type ?? '';
        return view('portal::instructor.supports.student-reply', compact('ticket', 'type'));
    }

    public function ticketClose(Request $request, $ticketCode)
    {
        $this->support->ticketClose($ticketCode);
        toastr()->success(translate('Support has been close successfully!'));
        return redirect()->back();
    }
}
