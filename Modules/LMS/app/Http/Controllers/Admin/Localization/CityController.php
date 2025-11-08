<?php

namespace Modules\LMS\Http\Controllers\Admin\Localization;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\Localization\CityRepository;

class CityController extends Controller
{
    /**
     * CityController constructor.
     *
     * @param CityRepository $city
     */
    public function __construct(protected CityRepository $city) {}

    /**
     * Display a listing of the cities.
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
        $response = $this->city->paginate(10, relations: [
            'country.translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            },
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }
        ], options: $options);
        $cities = $response['data'] ?? [];

        $countResponse = $this->city->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        // Return the view with the list of cities
        return view('portal::admin.localization.city.index', compact('cities', 'countData'));
    }

    /**
     * Show the form for creating a new city.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view for the city creation form
        return view('portal::admin.localization.city.create');
    }

    /**
     * Store a newly created city in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add a city
        if (!has_permissions($request->user(), ['add.city'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the city using the repository
        $city = $this->city->save($request->all());
        if ($city['status'] != 'success') {
            return response()->json($city);
        }
        // Return a success response with a redirect URL
        return $this->jsonSuccess('City has been saved successfully!', route('city.index'));
    }

    /**
     * Show the form for editing the specified city.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a city
        if (!has_permissions($request->user(), ['edit.city'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the city for the given ID
        $response = $this->city->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        if ($response['status'] !== 'success') {
            // Return a 404 view if the city is not found
            return view('portal::admin.404');
        }
        $city = $response['data'];
        // Return the view for the city edit form
        return view('portal::admin.localization.city.edit', compact('city'));
    }

    /**
     * Update the specified city in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit a city
        if (!has_permissions($request->user(), ['edit.city'])) {
            return json_error('You have no permission.');
        }
        // Attempt to update the city using the repository
        $city = $this->city->update($id, $request->all());
        if ($city['status'] != 'success') {
            // Return the response from the city update attempt
            return response()->json($city);
        }
        // Return a success response with a redirect URL
        return $this->jsonSuccess('City has been updated successfully!', route('city.index'));
    }

    /**
     * Change the status of the specified city.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to change city status
        if (!has_permissions($request->user(), ['status.city'])) {
            return json_error('You have no permission.');
        }

        // Change the status of the city using the repository
        $state = $this->city->statusChange(id: $id);
        return response()->json($state);
    }

    /**
     * Remove the specified city from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete a city
        if (!has_permissions($request->user(), ['delete.city'])) {
            return json_error('You have no permission.');
        }
        // Attempt to delete the city using the repository
        $response = $this->city->delete(id: $id, data: [
            'status' => 0,
        ]);
        $response['url'] = route('city.index');
        return response()->json($response);
    }


    /**
     * Remove the specified city from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a city
        if (!has_permissions($request->user(), ['delete.city'])) {
            return json_error('You have no permission.');
        }
        $response = $this->city->restore(id: $id);
        $response['url'] = route('city.index');
        return response()->json($response);
    }
}
