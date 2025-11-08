<?php

namespace Modules\LMS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\LMS\Models\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\LMS\Classes\DatabaseManager;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Classes\EnvironmentManager;
use Modules\LMS\Classes\PermissionsChecker;
use Modules\LMS\Classes\FinalInstallManager;
use Modules\LMS\Classes\RequirementsChecker;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Classes\InstalledFileManager;
use Modules\LMS\Services\ResourceMonitor;

class InstallerController extends Controller
{
    protected $requirements;

    protected $permissions;

    protected $environmentManager;

    /* Minimum PHP Version Supported (Override is in installer.php config file).
    *
    * @var _minPhpVersion
    */
    private $databaseManager;

    public function __construct(
        DatabaseManager $databaseManager,
        RequirementsChecker $checker,
        PermissionsChecker $pchecker,
        EnvironmentManager $environmentManager
    ) {

        $this->databaseManager = $databaseManager;
        $this->requirements = $checker;
        $this->permissions = $pchecker;
        $this->environmentManager = $environmentManager;
    }

    /**
     * installContent
     */
    public function installContent()
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(config('installer.core.minPhpVersion'));
        $requirements = $this->requirements->check(config('installer.requirements'));
        $permissions = $this->permissions->check(config('installer.permissions'));

        return view('lms::installer.index', compact('phpSupportInfo', 'requirements', 'permissions'));
    }

    /**
     * requirement
     *
     * @param  mixed  $request
     */
    public function requirement(Request $request)
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(config('installer.core.minPhpVersion'));
        $requirements = $this->requirements->check(config('installer.requirements'));
        $permissions = $this->permissions->check(config('installer.permissions'));
        if ($request->ajax()) {

            if (isset($requirements['errors']) || isset($phpSupportInfo['supported']) !== true) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please make sure Server Requirements'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'url' => route('install.permission')
                ]);
            }
        }

        return view('lms::installer.index', compact('phpSupportInfo', 'requirements', 'permissions'));
    }

    /**
     * permission
     *
     * @param  mixed  $request
     */
    public function permission(Request $request)
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(config('installer.core.minPhpVersion'));
        $requirements = $this->requirements->check(config('installer.requirements'));
        $permissions = $this->permissions->check(config('installer.permissions'));
        if ($request->ajax()) {
            if (isset($permissions['errors']) == true) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please make sure folder Permissions'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'url' => route('install.environment.form')
                ]);
            }
        }

        return view('lms::installer.index', compact('phpSupportInfo', 'requirements', 'permissions'));
    }
    public function environmentForm()
    {
        return view('lms::installer.index');
    }

    /**
     * environment
     *
     * @param  mixed  $request
     */
    public function environment(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'app_name' => 'required',
                    'app_debug' => 'required',
                    'environment' => 'required',
                    'app_log_level' => 'required',
                    'app_url' => 'required',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
            Session::put('environment', $request->all());

            return response()->json([
                'status' => true,
                'url' => route('license.form')
            ]);
        }

        return redirect(404);
    }
    public function licenseForm()
    {
        return view('lms::installer.index');
    }
    public function databaseForm()
    {
        return view('lms::installer.index');
    }
    /**
     * database
     *
     * @param  mixed  $request
     */
    public function database(Request $request)
    {
        $request->merge(Session::get('environment'));
        try {
            $rules = config('installer.environment.form.rules');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            if (! $this->checkDatabaseConnection($request)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Could not connect to the database.'
                ]);
            }

            $this->environmentManager->saveFileWizard($request);

            return response()->json([
                'status' => true,
                'message' => 'd',
                'url' => route('install.import-demo')
            ]);
        } catch (\Exception $e) {
            // return $e->getMessage();
        }
    }
    /**
     * importDemo
     */
    public function importDemo()
    {
        Artisan::call('config:clear');

        return view('lms::installer.index');
    }
    /**
     * imported
     *
     * @param  mixed  $redirect
     */
    public function imported(Redirector $redirect)
    {
        try {
            if (Request()->demo_import == 'on') {
                $this->databaseManager->migrateTable();
                $sql = File::get(public_path('demo.sql'));
                DB::connection()->getPdo()->exec($sql);
            } else {
                $this->databaseManager->migrateAndSeed();
                $sql = File::get(public_path('translate.sql'));
                DB::connection()->getPdo()->exec($sql);
            }
            return $redirect->route('install.final');
        } catch (\Throwable $th) {
            return $redirect->route('install.final');
        }
    }

    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {

        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        $totalUser = User::count();
        $storagePath = public_path('storage');

        if (! is_dir($storagePath)) {
            Artisan::call('storage:link');
        }
        $this->saveLicenseInfo();
        return view('lms::installer.index', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile', 'totalUser'));
    }

    /**
     * If application is already installed.
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }

    /**
     * purchaseCode
     *
     * @param  mixed  $request
     */
    public function purchaseCode(Request $request)
    {
        try {
            // Validate the request.
            $validator = Validator::make($request->all(), [
                'license_code' => 'required',
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
            $response = $this->verifyApi($request);
            $data = [
                'email' => $request->email,
                'code' => $request->license_code,
            ];
            $identifierInfo = [
                'identifier' => $request->email,
                'hash' => $request->license_code,
            ];
            Storage::disk('local')->put('file.txt', json_encode($data));
            Storage::disk('local')->put('matrix.json', json_encode($identifierInfo));
            return response()->json([
                'status' =>   $response['status'],
                'message' => $response['result'],
                'url' => route('install.database.form')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $response['status'],
                'message' => $e->getMessage()
            ]);
        }
    }

    private function checkDatabaseConnection(Request $request)
    {
        DB::purge();

        $connection = $request->input('database_connection');
        $settings = config("database.connections.$connection");
        config(
            [
                'database' => [
                    'default' => $connection,
                    'connections' => [
                        $connection => array_merge(
                            $settings,
                            [
                                'driver' => $connection,
                                'host' => $request->input('database_hostname'),
                                'port' => $request->input('database_port'),
                                'database' => $request->input('database_name'),
                                'username' => $request->input('database_username'),
                                'password' => $request->input('database_password'),
                            ]
                        ),
                    ],
                ],
            ]
        );

        try {
            DB::reconnect($connection);
            Schema::connection($connection)->getConnection()->reconnect();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function licenseVerifyForm()
    {
        return view('lms::installer.license');
    }

    public function licenseVerify(Request $request, ResourceMonitor $monitor)
    {
        try {
            $validator = Validator::make($request->all(), [
                'license_code' => 'required',
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
            $response = $this->verifyApi($request);
            $monitor->analyzeResource($request->email, $request->license_code);
            $data = '{"status": true}';
            ThemeSetting::updateOrCreate(['key' => 'license'], ['content' => $data]);
            return response()->json([
                'status' => $response['status'],
                'message' => $response['result'],
                'url' => route('home.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    protected function verifyApi(Request $request)
    {
        return [
            'status' => true,
            'result' => 'License verified successfully'
        ];
    }


    protected function saveLicenseInfo()
    {
        $purchaseInfo = json_decode(Storage::disk('local')->get('file.txt'), true);
        $data['email'] =  $purchaseInfo['email'] ?? '';
        $data['license_code'] = $purchaseInfo['code'] ?? '';
        $data['status'] = true;
        $response = json_encode($data);
        ThemeSetting::updateOrCreate(
            ['key' => 'license'],
            ['content' => $response]
        );
    }
}
