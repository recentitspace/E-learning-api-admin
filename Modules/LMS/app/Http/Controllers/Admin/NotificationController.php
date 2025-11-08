<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\NotificationTemplateRepository;

class NotificationController extends Controller
{
    public function __construct(protected NotificationTemplateRepository $notification) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->notification->paginate(10);
        $notifications = $response['data'] ?? [];
        return view('portal::admin.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portal::admin.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Check if the user has permission to add a notification.
        if (!has_permissions($request->user(), ['add.notification'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the new notification data.
        $response = $this->notification->save($request->all());

        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        return $this->jsonSuccess('Notification has been saved successfully!', route('notification.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $notification = $this->notification->first($id)['data'];
        return view('portal::admin.notification.create', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to edit a notification.
        if (!has_permissions($request->user(), ['edit.notification'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the notification data.
        $response = $this->notification->update($id, $request->all());

        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        return $this->jsonSuccess('Notification has been updated successfully!', route('notification.index'));
    }

    /**
     * history the specified resource in storage.
     */
    public function history(Request $request)
    {
        $notifications = $request->user()
            ->notifications()->latest()
            ->paginate(10);
        return view('portal::admin.notification.history', compact('notifications'));
    }

    /**
     *  notificationHistoryStatus
     *
     * @param  int  $id
     * @param  mixed  $request
     */
    public function notificationHistoryStatus($id, Request $request)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->read_at = $notification->read_at == null ? now() : null;
        $notification->update();
        if ($request->ajax()) {
            return [
                'status' => 'success',
                'message' => translate('Status Change Successfully')
            ];
        }
        return redirect()->route('notification.history');
    }

    /**
     * Delete a specific notification.
     *
     * @param  int  $id
     * @param  Request  $request
     * Delete a specific notification.
     */
    public function notificationHistoryDelete($id, Request $request)
    {
        $request->user()->notifications()->where('id', $id)->delete();
        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully'),
            'url' => route('notification.history')
        ];
    }
    /**
     * Method notificationReadAll
     *
     * @param  Request $request
     */
    public function notificationReadAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        toastr()->success(translate('Notification Read Successfully'));

        return redirect()->back();
    }
}
