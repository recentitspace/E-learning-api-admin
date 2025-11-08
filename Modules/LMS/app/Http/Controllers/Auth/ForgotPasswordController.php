<?php


namespace Modules\LMS\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Auth\UserRepository;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showForm()
    {
        return view('theme::forgot-password.index');
    }

    public function forgotPassword(Request $request)
    {

        return UserRepository::forgotPassword($request);
    }
    public function passwordReset($token)
    {
        return view('theme::forgot-password.index', compact('token'));
    }

    public function passwordUpdate(Request $request)

    {
        return UserRepository::passwordUpdate($request);
    }
}
