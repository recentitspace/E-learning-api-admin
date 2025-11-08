<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\General\ThemeSettingRepository;

class ThemeSettingController extends Controller
{
    public function __construct(protected ThemeSettingRepository $themeSetting) {}


    /**
     * theme Option
     */
    public function index()
    {
        return view('portal::admin.setting-option.index');
    }

    public function backendSetting()
    {
        return view('portal::admin.backend-setting.index');
    }

    /**
     * Theme Setting
     *
     * @param  mixed  $request
     */
    public function themeSetting(Request $request)
    {

        // Check user permission to change language status
        if (!has_permissions($request->user(), ['edit.themesetting'])) {
            return json_error('You have no permission.');
        }
        $response = $this->themeSetting->updateOrCreate($request);
        return response()->json($response);
    }
    /**
     * base64 image upload
     *
     * @param  mixed  $request
     * @return JsonResponse
     */
    public function imageUpload(Request $request)
    {

        try {
            $folder = isset($request->type) ? 'lms/certificates' : 'lms/theme-options';
            $result = $this->themeSetting->base64ImgUpload($request->image,  $request->old_file ? $request->old_file : '', folder: $folder);

            return response()->json([
                'status' => 'success',
                'image_name' => $result['imageName'],
                'path' => $result['path']
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
