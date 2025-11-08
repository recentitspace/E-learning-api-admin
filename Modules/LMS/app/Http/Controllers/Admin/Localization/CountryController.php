<?php

namespace Modules\LMS\Http\Controllers\Admin\Localization;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\Localization\CountryRepository;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected CountryRepository $country) {}

    /**
     * Display a listing of the resource.
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
        $response = $this->country->paginate(10, options: $options, relations: ['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);
        $countries = $response['data'] ?? [];

        $countResponse = $this->country->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }


        return view('portal::admin.localization.country.index', compact('countries', 'countData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('portal::admin.localization.country.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {  // Check user permission 
        if (!has_permissions($request->user(), ['add.country'])) {
            return json_error('You have no permission.');
        }

        // Get Country.
        $country = $this->country->save($request->all());
        // return response view.
        return $country['status'] === 'success'
            ? $this->jsonSuccess('Country has been saved successfully!', route('country.index'))
            : response()->json($country);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, Request $request)
    {
        // Check user permission 
        if (!has_permissions($request->user(), ['edit.country'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Get Country.
        $response = $this->country->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        // return response view.
        $country = $response['data'];
        return view('portal::admin.localization.country.form', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request): JsonResponse
    {
        // Check user permission 
        if (!has_permissions($request->user(), ['edit.country'])) {
            return json_error('You have no permission.');
        }

        // Get Country.
        $country = $this->country->update($id, $request->all());
        // return response .
        return $country['status'] === 'success'
            ? $this->jsonSuccess('Country has been updated successfully!', route('country.index'))
            : response()->json($country);
    }

    /**
     * Change the status of the specified resource.
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {   // Check user permission 
        if (!has_permissions($request->user(), ['status.country'])) {
            return json_error('You have no permission.');
        }

        $country = $this->country->statusChange($id);

        return response()->json($country);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {    // Check user permission 
        if (!has_permissions($request->user(), ['delete.country'])) {
            return json_error('You have no permission.');
        }
        // Get Country.
        $response = $this->country->delete($id);

        $response['url'] = route('country.index');
        return response()->json($response);
    }

    /**
     * Get states by country ID.
     */
    public function stateGetByCountry(int $id): JsonResponse
    {
        $states = $this->country->stateGetByCountry($id);
        return response()->json($states);
    }


    /**
     * Remove the specified country from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a country
        if (!has_permissions($request->user(), ['delete.country'])) {
            return json_error('You have no permission.');
        }

        $response = $this->country->restore(id: $id);
        $response['url'] = route('country.index');

        return response()->json($response);
    }
}
