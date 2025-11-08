<?php

namespace Modules\LMS\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Contact\ContactRepository;

class ContactController extends Controller
{
    public function __construct(protected ContactRepository $contact) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $contacts = $this->contact->paginate(item: 10)['data'];

        return view('portal::admin.contact.index', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function view($id)
    {
        //
        $contact = $this->contact->first($id);
        $contact = $contact['data'];

        return view('portal::admin.contact.reply', compact('contact'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function reply(Request $request)
    {
        //
        if (!has_permissions($request->user(), ['reply.contact'])) {
            return json_error('You have no permission.');
        }
        $replyContact = $this->contact->reply($request);
        if ($replyContact['status'] == 'success') {
            return response()->json([
                'status' => 'success',
                'url' => route('contact.index'),
                'message' => translate('Reply Successfully.')
            ]);
        }

        return $replyContact;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to change the status of a contact.
        if (!has_permissions($request->user(), ['delete.contact'])) {
            return json_error('You have no permission.');
        }
        $contact = $this->contact->delete($id);
        return response()->json($contact);
    }
}
