<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BackendSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('portal::admin.backend-setting.index');
    }
}
