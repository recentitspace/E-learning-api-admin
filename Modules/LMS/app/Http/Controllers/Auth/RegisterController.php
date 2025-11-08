<?php

namespace Modules\LMS\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\RegisterRepository;

class RegisterController extends Controller
{
    public function __construct(protected RegisterRepository $register) {}

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request): JsonResponse
    {
        $user = $this->register->userRegister($request);
        if ($user['status'] !== 'success') {
            return response()->json($user);
        }
        return response()->json([
            'status' => $user['status'],
            'message' => translate('Thank Your For Register and Please Verify Your Email')
        ]);
    }

    public function registerForm()
    {
        return view('theme::register.register');
    }
}
