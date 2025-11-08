<?php

namespace Modules\LMS\Http\Controllers\Instructor\Courses\Bundle;

use Illuminate\Http\Request;
use Modules\LMS\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Http\Requests\BundleRequest;
use Modules\LMS\Repositories\Courses\Bundle\BundleRepository;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected BundleRepository $bundle) {}

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
        $response = $this->bundle->bundleGetByUser(options: $options);
        $bundles = $response ?? [];
        $countResponse = $this->bundle->trashCount(options: [
            'where' => ['user_id' => authCheck()->id]
        ]);
        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $response =  $countResponse['data'] ?? [];
            $countData =  !empty($response) ? $response->toArray() : $countData;
        }
        return view('portal::instructor.course.bundle.index', compact('bundles', 'countData'));
    }

    /**
     * create
     */
    public function create(): View
    {
        return view('portal::instructor.course.bundle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BundleRequest $request): JsonResponse
    {
        $response = $this->bundle->save($request);
        $bundleId = $response['bundle_id'] ?? '';
        if (empty($request->bundle_id)) {
            $response['url'] = route('instructor.bundle.edit', $bundleId);
        }
        $response['message'] = translate("Update Successfully");
        return response()->json($response);
    }

    /**
     * Show the specified resource.
     */
    public function edit($id, Request $request)
    {

        $locale = $request->locale ?? app()->getLocale();
        $response = $this->bundle->first(
            $id,
            relations: [
                'levels',
                'bundleOutComes',
                'bundleFaqs',
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale);
                }
            ],
            options: [
                'where' => ['user_id' => authCheck()->id]
            ]
        );

        // Check if the update was successful.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $bundle = $response['data'] ?? null;
        if ($bundle->creator_type == "org") {
            $message = "This bundle owner is an organization. You can't edit this bundle.";
            toastr()->error(translate($message));
            return redirect()->back();
        }
        $user = User::with('courses')->where('id',   $bundle->user_id)->first();
        $courses = $user?->courses ?? [];
        return view('portal::instructor.course.bundle.edit', compact('bundle', 'courses'));
    }


    /**
     * Show the specified resource.
     */
    public function translate($id, Request $request)
    {

        $locale = $request->locale ?? app()->getLocale();
        $response = $this->bundle->first(
            $id,
            relations: [
                'levels',
                'bundleOutComes',
                'bundleFaqs',
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale);
                }
            ],
            options: [
                'where' => ['user_id' => authCheck()->id]
            ]
        );
        // Check if the update was successful.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $bundle = $response['data'] ?? null;
        if ($bundle->creator_type == "org") {
            $message = "This bundle owner is an organization. You can't edit this bundle.";
            toastr()->error(translate($message));
            return redirect()->back();
        }
        return view('portal::instructor.course.bundle.translate', compact('bundle'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $response = $this->bundle->delete(id: $id);
        $response['url'] = route('instructor.bundle.index');
        $bundle = $response['data'] ?? null;
        if ($bundle->creator_type == "org") {
            $message = "This bundle owner is an organization. You can't edit this bundle.";
            return response()->json(['status' => 'error', 'message' => $message]);
        }
        return response()->json($response);
    }

    public function thumbnailDelete($id)
    {
        $response = $this->bundle->thumbnailDelete(id: $id);
        return response()->json($response);
    }

    /**
     * restore the specified bundle from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id)
    {
        $response = $this->bundle->restore(id: $id);
        $response['url'] = route('instructor.bundle.index');
        return response()->json($response);
    }
}
