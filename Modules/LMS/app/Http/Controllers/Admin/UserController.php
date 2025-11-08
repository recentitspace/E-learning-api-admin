<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Auth\UserRepository;

class UserController extends Controller
{
    public function __construct(protected UserRepository $user) {}



    public function applyUsers()
    {
        $applyUsers = $this->user->getUserByGuard('student');

        return view('portal::admin.student.index', compact('applyUsers'));
    }
}
