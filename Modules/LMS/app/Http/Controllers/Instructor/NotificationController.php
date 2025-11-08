<?php

namespace Modules\LMS\Http\Controllers\Instructor;

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
        $notifications = $this->notification->paginate(10)['data'];
        return view('portal::instructor.notification.index', compact('notifications'));
    }
    /**
     * history the specified resource in storage.
     */
    public function history(Request $request)
    {
        $notifications = $request->user()
            ->notifications()->latest()
            ->paginate(10);
        return view('portal::instructor.notification.history', compact('notifications'));
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
        return redirect()->route("instructor.notification.history");
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
            'url' => route('instructor.notification.history')
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
