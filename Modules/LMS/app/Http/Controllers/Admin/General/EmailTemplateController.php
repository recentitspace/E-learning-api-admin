<?php

namespace Modules\LMS\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\General\EmailTemplateRepository;

class EmailTemplateController extends Controller
{
    public function __construct(protected EmailTemplateRepository $emailTemplate) {}

    /**
     * Display a listing of email templates.
     */
    public function index(): View
    {
        // Retrieve paginated email templates
        $emailTemplates = $this->emailTemplate->paginate(item: 10)['data'];
        return view('portal::admin.email-template.index', compact('emailTemplates'));
    }

    /**
     * Show form for creating a new email template.
     */
    public function create(): View
    {
        return view('portal::admin.email-template.create');
    }

    /**
     * Store a newly created email template in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if user has permission to add email templates
        if (!has_permissions($request->user(), ['add.emailtemplate'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save email template and capture the response
        $emailTemplate = $this->emailTemplate->save($request->all());


        return $emailTemplate['status'] !== 'success'
            ? response()->json($emailTemplate)
            :  $this->jsonSuccess('Email Template has been saved successfully!', route('email-template.index'));
    }

    /**
     * Show form for editing the specified email template.
     */
    public function edit($id, Request $request)
    {

        // Retrieve email template for editing
        $emailTemplate = $this->emailTemplate->first(value: $id)['data'];
        return view('portal::admin.email-template.create', compact('emailTemplate'));
    }

    /**
     * Update the specified email template in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Check if user has permission to edit email templates
        if (!has_permissions($request->user(), ['edit.emailtemplate'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update email template and capture the response
        $emailTemplate = $this->emailTemplate->update($id, $request);

        // Return response based on update status
        return $emailTemplate['status'] !== 'success'
            ? response()->json($emailTemplate)
            :  $this->jsonSuccess('Email Template has been updated successfully!', route('email-template.index'));
    }
}
