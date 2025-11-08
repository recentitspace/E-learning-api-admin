<?php

namespace Modules\LMS\Http\Controllers\Admin\IconProviders;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\IconProviders\IconRepository;

class IconController extends Controller
{
    /**
     *
     * @param IconRepository $icon
     */
    public function __construct(protected IconRepository $icon) {}

    /**
     * Display a listing of the icons.
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
        $response = $this->icon->paginate(10, relations: ['provider'], options: $options);
        $icons = $response['data'] ?? [];

        $countResponse = $this->icon->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }


        // Return the view with the list of icons
        return view('portal::admin.icon-provider.icon.index', compact('icons', 'countData'));
    }

    /**
     * Show the form for creating a new icon.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new icon
        return view('portal::admin.icon-provider.icon.form');
    }

    /**
     * Store a newly created icon in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check user permission to add a new icon
        if (!has_permissions($request->user(), ['add.icon'])) {
            return json_error('You have no permission.');
        }

        // Save the new icon data
        $icon = $this->icon->save($request->all());
        if ($icon['status'] !== 'success') {
            return response()->json($icon);
        }
        return $this->jsonSuccess('Icon has been saved successfully!', route('icon.index'));
    }

    /**
     * Show the form for view the specified icon.
     *
     * @return View
     */
    public function show($id): View
    {
        // Return the view to create a new icon
        $response = $this->icon->first($id);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $icon = $response['data'];
        return view('portal::admin.icon-provider.icon.view', compact('icon'));
    }


    /**
     * Show the form for editing the specified icon.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(int $id, Request $request)
    {
        // Check user permission to edit the icon
        if (!has_permissions($request->user(), ['edit.icon'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Retrieve the icon data for editing
        $response = $this->icon->first($id);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $icon = $response['data'] ?? null;

        return view('portal::admin.icon-provider.icon.form', compact('icon'));
    }

    /**
     * Update the specified icon in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        // Check user permission to edit the icon
        if (!has_permissions($request->user(), ['edit.icon'])) {
            return json_error('You have no permission.');
        }

        // Update the icon data
        $icon = $this->icon->update($id, $request->all());
        if ($icon['status'] !== 'success') {
            return response()->json($icon);
        }
        return $this->jsonSuccess('Icon has been updated successfully!', route('icon.index'));
    }

    /**
     * Remove the specified icon from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check user permission to delete the icon
        if (!has_permissions($request->user(), ['delete.icon'])) {
            return json_error('You have no permission.');
        }

        // Delete the icon
        $response = $this->icon->delete(id: $id, data: [
            'status' => 0
        ]);
        $response['url'] = route('icon.index');
        return response()->json($response);
    }

    /**
     * Change the status of the specified icon.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check user permission to change the icon's status
        if (!has_permissions($request->user(), ['status.icon'])) {
            return json_error('You have no permission.');
        }

        // Change the status of the icon
        $icon = $this->icon->statusChange(id: $id);
        return response()->json($icon);
    }

    /**
     * Remove the specified icon from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a icon
        if (!has_permissions($request->user(), ['delete.icon'])) {
            return json_error('You have no permission.');
        }
        $response = $this->icon->restore(id: $id);
        $response['url'] = route('icon.index');
        return response()->json($response);
    }
}
