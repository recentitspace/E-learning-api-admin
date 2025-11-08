<?php

namespace Modules\LMS\Http\Controllers\Admin\MeetProvider;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\MeetProvider\MeetProviderRepository;

class MeetProviderController extends Controller
{

    /**
     * MeetProviderController constructor.
     *
     * @param MeetProviderRepository $provider
     */
    public function __construct(protected MeetProviderRepository $provider) {}

    /**
     * Display a listing of meeting providers.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve paginated meeting providers
        $response = $this->provider->paginate(10);
        $meetingProviders = $response['data'];

        // Return the view with the meeting providers list
        return view('portal::admin.meet-provider.index', compact('meetingProviders'));
    }

    /**
     * Show the form for creating a new meeting provider.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new meeting provider
        return view('portal::admin.meet-provider.create');
    }

    /**
     * Store a newly created meeting provider in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a meeting provider
        if (!has_permissions($request->user(), ['add.meeting'])) {
            return json_error('You have no permission.');
        }

        // Save the new meeting provider
        $response = $this->provider->save($request);
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        return $this->jsonSuccess(
            'Meeting Provider has been saved successfully!',
            route('meet-provider.index')
        );
    }


    /**
     * Show the form for view the specified category.
     *
     * @return View
     */
    public function show($id): View
    {
        // Return the view to create a new icon
        $response = $this->provider->first($id);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $meetingProvider = $response['data'] ?? [];
        return view('portal::admin.meet-provider.view', compact('meetingProvider'));
    }

    /**
     * Show the form for editing the specified meeting provider.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(int $id, Request $request)
    {
        // Check if the user has permission to edit the meeting provider
        if (!has_permissions($request->user(), ['edit.meeting'])) {
            toastr()->error(translate('You have no permission.'));
            return back();
        }

        // Retrieve the meeting provider data for editing
        $meetingProvider = $this->provider->first($id)['data'];
        return view('portal::admin.meet-provider.create', compact('meetingProvider'));
    }

    /**
     * Update the specified meeting provider in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Check if the user has permission to update the meeting provider
        if (!has_permissions($request->user(), ['edit.meeting'])) {
            return json_error('You have no permission.');
        }

        // Update the meeting provider data
        $provider = $this->provider->update($id, $request);
        if ($provider['status'] !== 'success') {
            return response()->json($provider);
        }

        return $this->jsonSuccess(
            'Meeting Provider has been updated successfully!',
            route('meet-provider.index')
        );
    }

    /**
     * Remove the specified meeting provider from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {

        // Check if the user has permission to delete the meeting provider
        if (!has_permissions($request->user(), ['delete.meeting'])) {
            return json_error('You have no permission.');
        }
        // Delete the meeting provider
        $response = $this->provider->delete($id);
        $response['url'] = route('meet-provider.index');
        return response()->json($response);
    }
}
