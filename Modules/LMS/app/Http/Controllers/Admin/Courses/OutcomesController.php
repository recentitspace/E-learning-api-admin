<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Repositories\Courses\OutcomesRepository;

class OutcomesController extends Controller
{
    /**
     * Class that handles the outcomes resource.
     */
    public function __construct(protected OutcomesRepository $outcomes) {}

    /**
     * Display a listing of all outcomes.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Retrieve all outcomes from the repository
        $outcomes = $this->outcomes::get();

        // Return the outcomes as a JSON response
        return response()->json($outcomes);
    }

    /**
     * Store a newly created outcome in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Add a slug to the request based on the title
        $request->request->add([
            'slug' => Str::slug($request->title),
        ]);

        // Save the new outcome and get the response
        $outcome = $this->outcomes->save($request->all());

        // Return the saved outcome as a JSON response
        return response()->json($outcome);
    }

    /**
     * Show the specified outcome resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        // Retrieve the specified outcome by ID
        $outcome = $this->outcomes->first($id);

        // Return the outcome as a JSON response
        return response()->json($outcome);
    }

    /**
     * Update the specified outcome in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        // Add a slug to the request based on the title
        $request->request->add([
            'slug' => Str::slug($request->title),
        ]);

        // Update the outcome with the given ID and get the response
        $outcome = $this->outcomes->update($id, $request->all());

        // Return the updated outcome as a JSON response
        return response()->json($outcome);
    }

    /**
     * Remove the specified outcome from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // Delete the specified outcome by ID and get the response
        $outcome = $this->outcomes->delete(id: $id);

        // Return the deletion response as a JSON response
        return response()->json($outcome);
    }

    /**
     * Retrieve outcomes based on a query.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function outcomesGetByQuery(Request $request): JsonResponse
    {
        // Search outcomes based on the request parameters
        $outcomes = $this->outcomes->outcomesSearch($request);

        // Prepare HTML output for the search results
        $output = '<ul class="search-data dropdown-menu" style="display:block; position:relative">';
        foreach ($outcomes as $outcome) {
            // Append each outcome title to the output list
            $output .= '<li><a href="#">' .${ $outcome->title} . '</a></li>';
        }
        $output .= '</ul>';

        // Return the generated output as a JSON response
        return response()->json($output);
    }
}
