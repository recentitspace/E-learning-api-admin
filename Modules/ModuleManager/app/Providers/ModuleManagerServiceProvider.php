<?php

namespace Modules\ModuleManager\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleManager\Console\VerifyModuleLicensesCommand;
use Modules\ModuleManager\Services\ModuleManager;
use Modules\ModuleManager\Services\EnvatoService;
use Illuminate\Console\Scheduling\Schedule;
use Modules\ModuleManager\Console\ModuleComposerCommand;

class ModuleManagerServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'ModuleManager';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'modulemanager';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerCommands();
        
        // Register scheduled tasks if auto updates are enabled
        if (config('module_manager.enable_auto_updates')) {
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                
                // Check for updates daily
                $schedule->call(function () {
                    app(ModuleManager::class)->checkForUpdates();
                })->daily();
                
                // Verify licenses according to configured interval
                $interval = config('module_manager.license_verification_interval', 30);
                $schedule->command('module:verify-licenses')->days($interval);
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        
        $this->app->singleton(ModuleManager::class, function ($app) {
            return new ModuleManager();
        });
        
        $this->app->singleton(EnvatoService::class, function ($app) {
            return new EnvatoService();
        });
    }
    
    /**
     * Register commands in the console.
     */
    protected function registerCommands()
    {
        $this->commands([
            VerifyModuleLicensesCommand::class,
            ModuleComposerCommand::class,
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path('module_manager.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'), 'module_manager'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge([$sourcePath]),
            $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ModuleManager::class,
            EnvatoService::class,
        ];
    }
}