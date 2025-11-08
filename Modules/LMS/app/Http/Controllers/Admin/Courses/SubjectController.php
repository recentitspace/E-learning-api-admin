<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\SubjectRepository;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected SubjectRepository $subject) {}

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
        $response = $this->subject->paginate(10, options: $options, relations: ['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);
        $subjects = $response['data'] ?? [];


        $countResponse = $this->subject->trashCount();

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::admin.course.subject.index', compact('subjects', 'countData'));
    }

    public function create(): view
    {
        return view('portal::admin.course.subject.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check authentication or permission.
        if (!has_permissions($request->user(), ['add.subject'])) {
            return  json_error('You have no permission.');
        }
        // Get subject.
        $response = $this->subject->save($request);

        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        toastr()->success(translate('Subject has been updated successfully!'));
        return response()->json(['status' => 'success', 'url' => route('subject.index')]);
    }

    /**
     *  edit
     *
     * @param  int  $id
     * @param  mixed  $id
     */
    public function edit($id, Request $request)
    {
        // Check authentication or permission.

        if (!has_permissions($request->user(), ['edit.subject'])) {
            toastr()->error('You have no permission.');
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Get subject.
        $response = $this->subject->first($id, relations: [
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);
        // Check response status.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        // return response view.
        $subject = $response['data'];
        return view('portal::admin.course.subject.form', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check authentication or permission.
        if (!has_permissions($request->user(), ['edit.subject'])) {
            return json_error('You have no permission.');
        }
        // Get subject.
        $response = $this->subject->update($id, $request);
        // Check response status.
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        toastr()->success(translate('Subject has been updated successfully!'));
        return response()->json(['status' => 'success', 'url' => route('subject.index')]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id, Request $request)
    {
        // Check authentication or permission.

        if (!has_permissions($request->user(), ['delete.subject'])) {
            return json_error('You have no permission.');
        }
        // Get subject.
        $response = $this->subject->delete(id: $id);
        $response['url'] = route('subject.index');
        return response()->json($response);
    }
    public function show($id)
    {
        $response = $this->subject->first(value: $id, withTrashed: true);

        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        $subject = $response['data'] ?? [];
        return view('portal::admin.course.subject.view', compact('subject'));
    }
    /**
     * Remove the specified subject from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a subject
        if (!has_permissions($request->user(), ['delete.subject'])) {
            return json_error('You have no permission.');
        }
        $response = $this->subject->restore(id: $id);
        $response['url'] = route('subject.index');
        return response()->json($response);
    }
}
