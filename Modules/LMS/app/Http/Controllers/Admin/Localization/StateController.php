<?php

namespace Modules\LMS\Http\Controllers\Admin\Localization;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\Localization\StateRepository;

class StateController extends Controller
{
    /**
     * StateController constructor.
     *
     * @param StateRepository $state
     */
    public function __construct(protected StateRepository $state) {}

    /**
     * Display a listing of the states.
     *
     * @return View
     */
    public function index(Request $request)
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
        $response = $this->state->paginate(10, relations: [
            'country.translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }, 
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }
        ], options: $options);

        $states = $response['data'] ?? [];


        $countResponse = $this->state->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        // Return the view with the list of states
        return view('portal::admin.localization.state.index', compact('states', 'countData'));
    }

    /**
     * Show the form for creating a new state.
     *
     * @return view
     */
    public function create(): view
    {
        // Return the view for the state creation form
        return view('portal::admin.localization.state.form');
    }

    /**
     * Store a newly created state in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a state
        if (!has_permissions($request->user(), ['add.state'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the state using the repository
        $state = $this->state->save($request->all());
        if ($state['status'] != 'success') {
            return response()->json($state);
        }

        // Return a success response with a redirect URL
        return $this->jsonSuccess('State has been saved successfully!', route('state.index'));
    }

    /**
     * Show the form for editing the specified state.
     *
     * @param int $id
     * @param Request $request
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a state
        if (!has_permissions($request->user(), ['edit.state'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the state for the given ID
        $state = $this->state->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        if ($state['status'] != 'success') {
            // Return a 404 view if the state is not found
            return view('portal::admin.404');
        }
        $state = $state['data'];
        // Return the view for the state edit form
        return view('portal::admin.localization.state.form', compact('state'));
    }
    /**
     * Update the specified state in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit a state
        if (!has_permissions($request->user(), ['edit.state'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the state using the repository
        $state = $this->state->update($id, $request->all());
        if ($state['status'] == 'success') {
            // Return a success response with a redirect URL
            return $this->jsonSuccess('State has been updated successfully!', route('state.index'));
        }

        // Return the response from the state update attempt
        return response()->json($state);
    }

    /**
     * Change the status of the specified state.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to change state status
        if (!has_permissions($request->user(), ['status.state'])) {
            return json_error('You have no permission.');
        }

        // Change the status of the state using the repository
        $state = $this->state->statusChange(id: $id);
        return response()->json($state);
    }

    /**
     * Remove the specified state from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete a state
        if (!has_permissions($request->user(), ['delete.state'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the state using the repository
        $response = $this->state->delete(id: $id);
        $response['url'] = route('state.index');
        return response()->json($response);
    }

    /**
     * Get cities by state ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function cityGetByState($id): JsonResponse
    {
        // Retrieve cities based on the provided state ID
        $cities = $this->state->cityGetByCountry($id);
        return response()->json($cities);
    }


    /**
     * Remove the specified state from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a state
        if (!has_permissions($request->user(), ['delete.state'])) {
            return json_error('You have no permission.');
        }

        $response = $this->state->restore(id: $id);
        $response['url'] = route('state.index');

        return response()->json($response);
    }
}
