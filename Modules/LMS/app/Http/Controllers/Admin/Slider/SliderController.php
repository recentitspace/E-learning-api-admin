<?php

namespace Modules\LMS\Http\Controllers\Admin\Slider;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\Slider\SliderRepository;

class SliderController extends Controller
{
    /**
     * Display a listing of the slider.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $languages = app('languages');
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
        $response = SliderRepository::paginate(item: 10, relations: ['hero', 'translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }], options: $options);

        $sliders = $response['data'] ?? [];
        $countResponse = SliderRepository::trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }
        return view('portal::admin.slider.index', compact('sliders', 'countData', 'languages'));
    }

    /**
     * Show the form for creating a new slider.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new slider
        return view('portal::admin.slider.form');
    }

    /**
     * Store a newly created slider in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check user permission to add a new slider
        if (!has_permissions($request->user(), ['add.slider'])) {
            return json_error('You have no permission.');
        }

        // Save the new slider data
        $slider = SliderRepository::save($request);
        if ($slider['status'] !== 'success') {
            return response()->json($slider);
        }
        return $this->jsonSuccess('slider has been saved successfully!', route('slider.index'));
    }

    /**
     * Show the form for editing the specified slider.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(int $id, Request $request)
    {

        // Check user permission to edit the slider
        if (!has_permissions($request->user(), ['edit.slider'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        
        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the slider data for editing
        $response = SliderRepository::first($id,  relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $slider = $response['data'];

        return view('portal::admin.slider.form', compact('slider', 'locale'));
    }
    /**
     * Update the specified slider in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {


        // Check user permission to edit the slider
        if (!has_permissions($request->user(), ['edit.slider'])) {
            return json_error('You have no permission.');
        }
        // Update the slider data

        $slider = SliderRepository::update($id, $request);

        if ($slider['status'] !== 'success') {
            return response()->json($slider);
        }
        return $this->jsonSuccess('slider has been updated successfully!', route('slider.index'));
    }

    /**
     * Remove the specified slider from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check user permission to delete the slider
        if (!has_permissions($request->user(), ['delete.slider'])) {
            return json_error('You have no permission.');
        }

        // Delete the slider
        $slider = SliderRepository::delete(id: $id);
        $slider['url'] = route('slider.index');
        return response()->json($slider);
    }

    /**
     * Restore the specified slider from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a slider
        if (!has_permissions($request->user(), ['delete.slider'])) {
            return json_error('You have no permission.');
        }

        $response = SliderRepository::restore(id: $id);
        $response['url'] = route('slider.index');

        return response()->json($response);
    }

    /**
     * Change the status of the specified slider.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check user permission to change the slider's status
        if (!has_permissions($request->user(), ['status.slider'])) {
            return json_error('You have no permission.');
        }

        // Change the status of the slider
        $slider = SliderRepository::statusChange(id: $id);
        return response()->json($slider);
    }
}
