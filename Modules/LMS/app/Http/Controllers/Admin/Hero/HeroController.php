<?php

namespace Modules\LMS\Http\Controllers\Admin\Hero;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\LMS\Repositories\Hero\HeroRepository;

class HeroController extends Controller
{
    /**
     * Display a listing of the Hero.
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
        $response = HeroRepository::paginate(item: 10, relations: ['theme'], options: $options);
        $heroes = $response['data'] ?? [];

        $countResponse = HeroRepository::trashCount();
        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }
        return view('portal::admin.hero.index', compact('heroes', 'countData'));
    }

    /**
     * Show the form for creating a new Hero.
     *
     * @return View
     */
    public function create(): View
    {

        // Return the view to create a new Hero
        return view('portal::admin.hero.form');
    }

    /**
     * Store a newly created hero in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->merge(['user_id' => Auth::guard('admin')->user()->id]);
        $request->merge(['status' => $request->status == 'on' ? 1 : 0]);
        // Check user permission to add a new hero
        if (!has_permissions($request->user(), ['add.hero'])) {
            return json_error('You have no permission.');
        }

        // Save the new hero data
        $hero = HeroRepository::save($request->all());
        if ($hero['status'] !== 'success') {
            return response()->json($hero);
        }
        return $this->jsonSuccess('Hero has been saved successfully!', route('hero.index'));
    }

    /**
     * Show the form for editing the specified hero.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(int $id, Request $request)
    {
        // Check user permission to edit the hero
        if (!has_permissions($request->user(), ['edit.hero'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Retrieve the hero data for editing
        $response = HeroRepository::first($id);
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $hero = $response['data'];


        return view('portal::admin.hero.form', compact('hero'));
    }

    /**
     * Update the specified hero in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $request->merge(['status' => $request->status == 'on' ? 1 : 0]);

        // Check user permission to edit the hero
        if (!has_permissions($request->user(), ['edit.hero'])) {
            return json_error('You have no permission.');
        }

        // Update the hero data
        $hero = HeroRepository::update($id, $request->all());
        if ($hero['status'] !== 'success') {
            return response()->json($hero);
        }
        return $this->jsonSuccess('hero has been updated successfully!', route('hero.index'));
    }

    /**
     * Restore the specified hero from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a hero
        if (!has_permissions($request->user(), ['delete.hero'])) {
            return json_error('You have no permission.');
        }

        $response = HeroRepository::restore(id: $id);
        $response['url'] = route('hero.index');

        return response()->json($response);
    }

    /**
     * Remove the specified hero from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check user permission to delete the hero
        if (!has_permissions($request->user(), ['delete.hero'])) {
            return json_error('You have no permission.');
        }

        // Delete the hero
        $hero = HeroRepository::delete(id: $id);
        $hero['url'] = route('hero.index');
        return response()->json($hero);
    }
}
