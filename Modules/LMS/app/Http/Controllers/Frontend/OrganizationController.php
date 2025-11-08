<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\UserRepository;

class OrganizationController extends Controller
{
    public function __construct(protected UserRepository $user) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->merge(['guard' => 'organization']);
        $organizations = $this->user->instructorList($request);
        if ($request->ajax()) {
            $result = view('theme::organization.organization-list', compact('organizations'))->render();

            return response()->json(
                [
                    'status' => true,
                    'data' => $result,
                    'total' => $organizations->total(),
                    'first_item' => $organizations->firstItem(),
                    'last_item' => $organizations->lastItem(),
                ]
            );
        }

        return view('theme::organization.index', compact('organizations'));
    }
}
