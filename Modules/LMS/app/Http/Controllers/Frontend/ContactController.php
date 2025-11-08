<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Contact\ContactRepository;

class ContactController extends Controller
{
    public function __construct(protected ContactRepository $contact) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('theme::contact.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $contact = $this->contact->save($request->all());
        if ($contact['status'] !== 'success') {
            return $contact;
        }
        return response()->json([
            'status' => $contact['status'],
            'message' => translate('Thanks for Contact Us')
        ]);
    }
}
