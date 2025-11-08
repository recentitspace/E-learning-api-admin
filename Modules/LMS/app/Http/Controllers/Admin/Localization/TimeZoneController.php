<?php

namespace Modules\LMS\Http\Controllers\Admin\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Localization\TimeZoneRepository;

class TimeZoneController extends Controller
{
    /**
     * Handle operations related to Time Zones.
     */
    public function __construct(protected TimeZoneRepository $timeZone) {}

    /**
     * Display a listing of the time zones.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $options = [];
        $filterType = '';
        if ($request->has('filter')) {
            $filterType = $request->filter ?? '';
        }
        switch ($filterType) {
            case 'trash':
                $options['onlyTrashed'] = [];
                break;
            case 'all':
                $options['withTrashed'] = [];
                break;
        }
        $response = $this->timeZone->paginate(10, options: $options);
        $timeZones = $response['data'] ?? [];

        $countResponse = $this->timeZone->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }
        // Return the view with the retrieved time zones
        return view('portal::admin.localization.timezone.index', compact('timeZones', 'countData'));
    }

    /**
     * Show the form for creating a new time zone.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view for creating a new time zone
        return view('portal::admin.localization.timezone.form');
    }

    /**
     * Store a newly created time zone in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a time zone
        if (!has_permissions($request->user(), ['add.time.zone'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the new time zone
        $response = $this->timeZone->save($request->all());
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }

        // Show success message and redirect to the index
        toastr()->success(translate('Time Zone has been saved successfully!'));
        return response()->json(['status' => 'success', 'url' => route('time-zone.index')]);
    }

    /**
     * Show the form for editing the specified time zone.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse|View
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit the time zone
        if (!has_permissions($request->user(), ['edit.time.zone'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Retrieve the time zone to be edited
        $response = $this->timeZone->first($id);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        // Pass the retrieved time zone data to the edit view
        $timeZone = $response['data'];
        return view('portal::admin.localization.timezone.form', compact('timeZone'));
        // Return a 404 view if the time zone was not found

    }

    /**
     * Update the specified time zone in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit the time zone
        if (!has_permissions($request->user(), ['edit.time.zone'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the time zone with the provided data
        $timeZone = $this->timeZone->update($id, $request->all());
        if ($timeZone['status'] !== 'success') {
            return response()->json($timeZone);
        }

        // Show success message and redirect to the index
        toastr()->success(translate('Time Zone has been updated successfully!'));
        return response()->json(['status' => 'success', 'url' => route('time-zone.index')]);
    }

    /**
     * Remove the specified time zone from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete the time zone
        if (!has_permissions($request->user(), ['delete.time.zone'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the specified time zone
        $timeZone = $this->timeZone->delete(id: $id, data: [
            'status' => 0,
        ]);
        $timeZone['url'] = route('time-zone.index');
        return response()->json($timeZone);
    }


    /**
     * Remove the specified time Zone from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a time Zone
        if (!has_permissions($request->user(), ['delete.time.zone'])) {
            return json_error('You have no permission.');
        }

        $response = $this->timeZone->restore(id: $id);
        $response['url'] = route('time-zone.index');

        return response()->json($response);
    }
}
