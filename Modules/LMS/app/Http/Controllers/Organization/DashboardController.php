<?php

namespace Modules\LMS\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\SearchSuggestionRepository;

class DashboardController extends Controller implements HasMiddleware
{
    public function __construct(
        protected SearchSuggestionRepository $suggestion,
        protected UserRepository $user
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['register']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->user->dashboardInfoOrganization();
        return view('portal::organization.index', compact('data'));
    }

    public function register(Request $request)
    {
        return view('portal::auth.organization-register');
    }

    public function searchingSuggestion(Request $request)
    {
        $results = $this->suggestion->searchSuggestion($request);

        return response()->json($results);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function students()
    {
        $students = $this->user->enrolledStudents();
        return view('portal::organization.student.student-list', compact('students'));
    }

    /**
     *  View Student Profile.
     */
    public function profile($id)
    {
        $user = $this->user->studentProfileView($id);

        return view('portal::admin.student.profile', compact('user'));
    }

    public function wishlists()
    {
        $response =  UserRepository::wishlist();
        $wishlists = $response['data'] ?? [];
        return view('portal::organization.wishlist.index', compact('wishlists'));
    }
    public function removeWishlist($id)
    {
        $response =  UserRepository::removeWishlist($id);
        $response['url'] = route('organization.wishlist');
        return  response()->json($response);
    }
}
