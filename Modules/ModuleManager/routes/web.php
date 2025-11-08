<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

Route::group(['prefix' => 'module-manager', 'middleware' => ['auth:admin', 'checkInstaller']], function () {
    Route::get('/', [ModuleManagerController::class, 'index'])->name('module-manager.index');
    Route::get('/installed', [ModuleManagerController::class, 'installed'])->name('module-manager.installed');
    Route::get('/marketplace', [ModuleManagerController::class, 'marketplace'])->name('module-manager.marketplace');
    Route::get('/envato', [ModuleManagerController::class, 'envato'])->name('module-manager.envato');
    Route::post('/search-envato', [ModuleManagerController::class, 'searchEnvato'])->name('module-manager.search-envato');
    
    // Module actions
    Route::post('/upload', [ModuleManagerController::class, 'upload'])->name('module-manager.upload');
    Route::post('/install-from-url', [ModuleManagerController::class, 'installFromUrl'])->name('module-manager.install-from-url');
    Route::post('/install-from-envato', [ModuleManagerController::class, 'installFromEnvato'])->name('module-manager.install-from-envato');
    Route::post('/{module}/enable', [ModuleManagerController::class, 'enable'])->name('module-manager.enable');
    Route::post('/{module}/disable', [ModuleManagerController::class, 'disable'])->name('module-manager.disable');
    Route::delete('/{module}', [ModuleManagerController::class, 'uninstall'])->name('module-manager.uninstall');
    
    // Updates
    Route::get('/updates', [ModuleManagerController::class, 'checkUpdates'])->name('module-manager.updates');
    Route::post('/{module}/update', [ModuleManagerController::class, 'update'])->name('module-manager.update');
    
    // Settings
    Route::get('/settings', [ModuleManagerController::class, 'settings'])->name('module-manager.settings');
    Route::post('/settings', [ModuleManagerController::class, 'saveSettings'])->name('module-manager.save-settings');
    Route::post('/verify-licenses', [ModuleManagerController::class, 'verifyLicenses'])->name('module-manager.verify-licenses');
});
