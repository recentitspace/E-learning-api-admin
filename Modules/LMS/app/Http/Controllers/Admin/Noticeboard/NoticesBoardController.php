<?php

namespace Modules\LMS\Http\Controllers\Admin\Noticeboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\NoticesBoardRepository;

class NoticesBoardController extends Controller
{
    public function __construct(protected NoticesBoardRepository $notice) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticesBoards = $this->notice->paginate(item: 10)['data'];

        return view('portal::admin.notices-board.index', compact('noticesBoards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portal::admin.notices-board.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add a time zone
        if (!has_permissions($request->user(), ['add.noticeboard'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the new time zone
        $response = $this->notice->save($request);
        if ($response['status'] !== 'success') {
            return $response;
        }
        toastr()->success(translate('Notification send successfully.'));
        return response()->json([
            'status' =>
            $response['status'],
            'url' => route('noticeboard.index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a notice
        if (!has_permissions($request->user(), ['edit.noticeboard'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        // Retrieve the notice for the given ID
        $response = $this->notice->first($id);
        if ($response['status'] != 'success') {
            // Return a 404 view if the notice is not found
            return view('portal::admin.404');
        }
        $notice = $response['data'];
        // Return the view for the notice edit form
        return view('portal::admin.notices-board.edit', compact('notice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to delete the notice
        if (!has_permissions($request->user(), ['delete.noticeboard'])) {
            return json_error('You have no permission.');
        }
        $noticeboard = $this->notice->delete($id);
        $noticeboard['url'] = route('noticeboard.index');
        return response()->json($noticeboard);
    }
}
