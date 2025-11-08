<?php

namespace Modules\LMS\Http\Controllers\Admin\Testimonial;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Testimonial\TestimonialRepository;

class TestimonialController extends Controller
{
    public function __construct(protected TestimonialRepository $testimonial) {}

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

        $response = TestimonialRepository::paginate(item: 10, relations: ['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }], options: $options);

        $testimonials = $response['data'] ?? [];
        $countResponse = TestimonialRepository::trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::admin.testimonial.index', compact('testimonials', 'countData'));
    }

    /**
     * create form.
     */
    public function create()
    {
        return view('portal::admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add a testimonial
        if (!has_permissions($request->user(), ['add.testimonial'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the testimonial
        $testimonial = $this->testimonial->save($request);

        if ($testimonial['status'] !== 'success') {
            return response()->json($testimonial);
        }

        return $this->jsonSuccess('Testimonial saved successfully!', route('testimonial.index'));
    }


    /**
     * view the specified resource.
     */
    public function show($id, Request $request)
    {
        // Retrieve the testimonial for editing
        $response = $this->testimonial->first($id, withTrashed: true);
        $testimonial = $response['data'] ?? null;
        return view('portal::admin.testimonial.view', compact('testimonial'));
    }

    /**
     * Edit the specified resource.
     */
    public function edit($id, Request $request)
    {

        // Check if the user has permission to edit the testimonial
        if (!has_permissions($request->user(), ['edit.testimonial'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the testimonial for editing
        $response = $this->testimonial->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        $testimonial = $response['data'] ?? [];

        return view('portal::admin.testimonial.create', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to edit the testimonial
        if (!has_permissions($request->user(), ['edit.testimonial'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the testimonial
        $testimonial = $this->testimonial->update($id, $request);

        if ($testimonial['status'] !== 'success') {
            return response()->json($testimonial);
        }
        return $this->jsonSuccess('Testimonial updated successfully!', route('testimonial.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to delete the testimonial
        if (!has_permissions($request->user(), ['delete.testimonial'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete the testimonial
        $testimonial = $this->testimonial->delete($id, [
            'status' => 0
        ]);
        $testimonial['url'] = route('testimonial.index');

        return response()->json($testimonial);
    }

    /**
     * Restore the specified testimonial from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a testimonial
        if (!has_permissions($request->user(), ['delete.testimonial'])) {
            return json_error('You have no permission.');
        }

        $response = TestimonialRepository::restore(id: $id);
        $response['url'] = route('testimonial.index');

        return response()->json($response);
    }

    /**
     *  statusChange
     *
     * @param  $id  $id
     */
    public function statusChange($id, Request $request): JsonResponse
    {
        // Check if the user has permission to change the status of the testimonial
        if (!has_permissions($request->user(), ['status.testimonial'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status of the testimonial
        $testimonial = $this->testimonial->statusChange($id);
        return response()->json($testimonial);
    }
}
