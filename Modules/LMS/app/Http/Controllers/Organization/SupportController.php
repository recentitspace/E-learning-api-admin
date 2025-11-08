<?php

namespace Modules\LMS\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\SupportTicket\SupportRepository;

class SupportController extends Controller
{
    public function __construct(protected SupportRepository $support, protected CourseRepository $course) {}

    public function index()
    {
        $tickets = $this->support->getSupports(10, type: 'platform');
        $coursesTickets = $this->support->getSupports(10, type: 'course');

        return view('portal::organization.supports.index', compact('coursesTickets', 'tickets'));
    }

    public function create(Request $request)
    {
        $request->merge(['organizations' => [authCheck()->id]]);
        $courses = $this->course->dashboardCourseFilter($request, null);

        return view('portal::organization.supports.create', compact('courses'));
    }

    /**
     * creating a new resource.
     */
    public function reply($id)
    {

        $ticket = $this->support->firstTicketById($id);

        return view('portal::organization.supports.reply', compact('ticket'));
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
            return $ticket;
        }
        return $this->jsonSuccess(
            'Reply has been update successfully!',
            route('support-ticket.ticket.index')
        );
    }

    public function deleteSupportFile($id)
    {
        return $this->support->deleteSupportFile($id);
    }

    public function store(Request $request)
    {
        $ticket = $this->support->save($request);
        if ($ticket['status'] !== 'success') {
            return $ticket;
        }
        toastr()->success(translate('Support has been saved successfully!'));
        return response()->json([
            'status' => 'success',
            'url' => $request->type == 'course' ? route('organization.supports.index') : route('organization.supports.index')
        ]);
    }

    public function ticketClose(Request $request, $ticketCode)
    {
        $this->support->ticketClose($ticketCode);
        toastr()->success(translate('Support has been close successfully!'));
        return redirect()->back();
    }
}
