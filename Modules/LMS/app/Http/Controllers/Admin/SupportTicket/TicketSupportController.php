<?php

namespace Modules\LMS\Http\Controllers\Admin\SupportTicket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\SupportTicket\SupportRepository;

class TicketSupportController extends Controller
{
    public function __construct(protected SupportRepository $support) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = $this->support->getSupports(10, type: 'platform');
        $coursesTickets = $this->support->getSupports(10, type: 'course');
        return view('portal::admin.support.index', compact('tickets', 'coursesTickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function reply($id)
    {
        $ticket = $this->support->firstTicketById($id);
        return view('portal::admin.support.reply', compact('ticket'));
    }

    /**
     *  ticketReply
     *
     * @param  mixed  $request
     */
    public function ticketReply(Request $request)
    {
        $ticket = $this->support->ticketReply($request);
        if ($ticket['status'] != 'success') {
            return redirect()->back();
        }
        return $this->jsonSuccess('Reply has been update successfully!', route('support-ticket.ticket.index'));
    }

    public function deleteSupportFile($id)
    {
        return $this->support->deleteSupportFile($id);
    }


    public function ticketClose(Request $request, $ticketCode)
    {
        $this->support->ticketClose($ticketCode);
        toastr()->success(translate('Support has been close successfully!'));
        return redirect()->back();
    }
}
