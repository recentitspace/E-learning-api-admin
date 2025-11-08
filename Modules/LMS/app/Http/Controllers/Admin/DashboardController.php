<?php

namespace Modules\LMS\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Repositories\DashboardRepository;
use Modules\Roles\Repositories\Staff\StaffRepository;
use Modules\LMS\Repositories\SearchSuggestionRepository;

class DashboardController extends Controller
{
    public function __construct(
        protected SearchSuggestionRepository $suggestion,
        protected DashboardRepository $dashboard
    ) {}

    /**
     * Display a listing of the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = $this->dashboard->dashboardInfo();
        return view('portal::admin.dashboard', compact('data'));
    }

    /**
     * Log out the current user and redirect to the login form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::guard('admin')->user();
        
        // Revoke all tokens
        if ($user) {
            $user->tokens()->delete();
        }
        
        Auth::guard('admin')->logout();
        Session::flush();
        
        // Clear cookies
        $response = redirect()->route('login');
        $response->cookie(\Illuminate\Support\Facades\Cookie::forget('auth_token'));
        $response->cookie(\Illuminate\Support\Facades\Cookie::forget('user_info'));
        
        return $response;
    }

    /**
     * Handle search suggestions based on user input.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchingSuggestion(Request $request): \Illuminate\Http\JsonResponse
    {
        $results = $this->suggestion->searchSuggestion($request);
        return response()->json($results);
    }

    public function assetsPath(Request $request)
    {
        return assets($request->path);
    }

    public function cacheClear()
    {

        Artisan::call('optimize:clear');
        toastr()->success(translate('Cache Clear Successfully'));
        return redirect()->back();
    }

    public function cacheOptimize()
    {
        Artisan::call('optimize');
        toastr()->success(translate('Cache Optimize Successfully'));
        return redirect()->back();
    }
    public function storageLink()
    {
        Artisan::call('storage:link');
        toastr()->success(translate('storage link Successfully'));
        return redirect()->back();
    }
    public function licenseRemoveForm()
    {
        return view('portal::admin.license.remove');
    }
    public function licenseRemove(Request $request)
    {
        try {
            $result = [
                'status' => 'success',
                'message' => 'License removed successfully.'
            ];
            Storage::delete('file.txt');
            $result['url'] = route('license.verify.form');
            $data = '{"status": false}';
            ThemeSetting::updateOrCreate(['key' => 'license'], ['content' => $data]);

            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ]);
        }
    }

    public function profile()
    {
        return view('portal::admin.profile.form');
    }

    public function profileUpdate(Request $request)
    {
        if (!has_permissions($request->user(), ['update.staff'])) {
            return json_error('You have no permission.');
        }
        $response = StaffRepository::update($request->id, $request);

        if ($response['status'] == 'success') {
            $admin = $response['data'];
            if ($request->filled('password') && $request->password !== $admin->password) {
                Auth::logout();
                Session::flush();
            }
        }
        return $response['status'] !== 'success'
            ? response()->json($response)
            : $this->jsonSuccess('Profile Update successfully.', route('admin.profile'));
    }

    public function lmsModule($name) {
        if(!module_enable_check($name)) {
           return view('portal::admin.module.index', compact('name'));
        }
        $moduleName = strtolower($name);
        $route = "{$moduleName}.index";
        return redirect()->route($route);
    }


    public function licenseUpdateForm()
    {
        return view('portal::admin.license.form');
    }

    public function licenseUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'license_code' =>  'required',
                'email' =>  'required',
            ]);
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'data' => $validator->errors()
                ];
            }
            // $response = Http::asForm()->post(
            //     'http://license.codexshaper.com/api/purchase/verify',
            //     [
            //         'license_code' => $request->license_code,
            //         'email' => $request->email,
            //         'host_url' => $request->getHost(),
            //     ]
            // );
            // $response = $response->getBody();
            // $result = json_decode($response, true);
            // if ($result['status'] !== true) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => $result['result']
            //     ]);
            // }
            $identifierInfo = [
                'identifier' => $request->email,
                'hash' => $request->license_code,
            ];
            Storage::disk('local')->put('matrix.json', json_encode($identifierInfo));
            toastr()->success('Update Successfully');
            return response()->json([
                'status' => 'success',
                'type' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' =>   $th->getMessage()
            ]);
        }
    }
}
