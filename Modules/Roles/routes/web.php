<?php

use Illuminate\Support\Facades\Route;
use Modules\Roles\Http\Controllers\AdminController;
use Modules\Roles\Http\Controllers\PermissionController;
use Modules\Roles\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web RoutesP
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    ['prefix' => 'admin'],
    function () {

        Route::controller(AdminController::class)->group(
            function () {
                Route::post('admin-login', 'login')->name('admin.login');
            }
        );
        Route::group(
            ['middleware' => ['auth:admin']],
            function () {
                Route::resource('staff', AdminController::class);
                Route::resource('permission', PermissionController::class);
                Route::resource('role', RoleController::class);
            }
        );
    }
);

Route::get('{any}', [AdminController::class, 'notFound'])->name('not.found')->middleware('checkInstaller');
