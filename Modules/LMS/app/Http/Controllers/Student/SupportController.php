<?php

namespace Modules\LMS\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\SupportTicket\SupportRepository;

class SupportController extends Controller
{
    /**
     * __construct
     */
    public function __construct(protected SupportRepository $support) {}

    /**
     * index
     */
    public function index()
    {
        $tickets = $this->support->getSupports(10, type: 'platform');
        return view('portal::student.supports.index', compact('tickets'));
    }

    /**
     * create
     */
    public function create()
    {
        return view('portal::student.supports.create');
    }

    /**
     * creating a new resource.
     */
    public function reply($id, Request $request)
    {

        $type = $request->type ?? '';
        $ticket = $this->support->firstTicketById($id);
        return view('portal::student.supports.reply', compact('ticket', 'type'));
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
     *  store
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
            'url' => $request->type == 'course' ? route('student.course.support.create') : route('student.supports.index')
        ]);
    }

    /**
     * courseSupport
     */
    public function courseSupport()
    {
        $tickets = $this->support->getSupports(10, type: 'course');
        return view('portal::student.supports.course-support', compact('tickets'));
    }

    /**
     * courseSupportCreate
     */
    public function courseSupportCreate()
    {
        return view('portal::student.supports.course-support-create');
    }

    public function ticketClose(Request $request, $ticketCode)
    {
        $this->support->ticketClose($ticketCode);
        toastr()->success(translate('Support has been close successfully!'));
        return redirect()->back();
    }
}
