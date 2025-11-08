<?php

namespace Modules\LMS\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Instructor\InstructorRepository;

class InstructorController extends Controller
{
    public function __construct(protected UserRepository $user, protected InstructorRepository $instructor) {}

    /**
     * Display a listing of the resource.
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

        $response = $this->user->organizationInstructors(options: $options);
        $instructors =  $response  ?? [];

        $countResponse = $this->user->trashCount(options: [
            'where' => [
                'organization_id' => authCheck()->id,
                'guard' => 'instructor'
            ]
        ]);
        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];
        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::organization.instructor.index', compact('instructors', 'countData'));
    }

    public function create()
    {
        return view('portal::organization.instructor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $instructor = $this->instructor->save($request);
        if ($instructor['status'] !== 'success') {
            return response()->json($instructor);
        }
        return $this->jsonSuccess(
            'Instructor Create Successfully',
            route('organization.instructor.index')
        );
    }

    public function edit($id, Request $request)
    {
        $locale = $request->locale ?? app()->getLocale();

        $instructor = $response['data'] ?? null;
        $instructor = $this->user->userFirst($id, withTrashed: true, locale: $locale);
        return view('portal::organization.instructor.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $instructor = $this->instructor->update($id, $request);
        if ($instructor['status'] !== 'success') {
            return response()->json($instructor);
        }
        return $this->jsonSuccess(
            'Instructor Update Successfully',
            route('organization.instructor.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $response = $this->user->delete($id);
        $response['url'] = route('organization.instructor.index');
        return response()->json($response);
    }

    /**
     *  the specified resource in edit.
     */
    public function profile($id, Request $request)
    {
        $locale = $request->locale ?? app()->getLocale();
        $user = $this->user->userFirst($id, withTrashed: true,  locale: $locale);
        return view('portal::organization.instructor.profile', compact('user'));
    }

    /**
     *  status change
     */
    public function statusChange($id, Request $request)
    {
        $instructor = $this->instructor->statusChange($id);
        return response()->json($instructor);
    }

    /**
     * user verify email.
     */
    public function verifyEmail($id, Request $request)
    {
        $user = $this->user->verifyMail($id);
        return response()->json($user);
    }


    public function restore(int $id)
    {
        $response = $this->user->restore(id: $id);
        $response['url'] = route('organization.instructor.index');
        return response()->json($response);
    }
}
