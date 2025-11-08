<?php

namespace Modules\LMS\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\General\ThemeSettingRepository;

class ThemeSettingController extends Controller
{
    public function __construct(protected ThemeSettingRepository $themeSetting) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //
        $themeSettings = $this->themeSetting->save($request);

        return response()->json($themeSettings);
    }
}
