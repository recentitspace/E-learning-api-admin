<?php

namespace Modules\LMS\Providers;

use Carbon\Carbon;
use Modules\LMS\Models\User;
use Modules\LMS\Models\Auth\Admin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Blade;
use Modules\LMS\Models\PaymentMethod;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Observers\ThemeSettingObserver;
use Modules\LMS\View\Components\Dashboard\Layout;
use Modules\LMS\Http\Middleware\BootstrapMiddleware;
use Modules\LMS\Providers\CookieConsentServiceProvider;
use Modules\LMS\Http\Middleware\CookieConsentMiddleware;
use Modules\LMS\Http\Middleware\CrossOriginHandler;
use Modules\LMS\Http\Middleware\InstallerValidMiddleware;
use Modules\LMS\Http\Middleware\LicenseActivationMiddleware;
use Modules\LMS\Http\Middleware\PerformanceMonitor;
use Modules\LMS\Models\Resources\PerformanceMetric;
use Modules\LMS\Services\ResourceMonitor;
use Modules\LMS\View\Components\Frontend\AuthenticationLayout;
use Modules\LMS\View\Components\Frontend\Layout as FrontendLayout;

class LMSServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'LMS';

    protected string $moduleNameLower = 'lms';

    /**
     * Boot the application events.
     */
    public function boot(Kernel $kernel): void
    {
        ThemeSetting::observe(ThemeSettingObserver::class);

        $this->app->singleton('options', function () {
            return get_options();
        });

        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerGurads();

        if (alreadyInstalled()) {
            $this->mailDriverSet();
            $this->paystackConfigure();
        }


        if (App::environment('production')) {
            URL::forceScheme('https');
        }

        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));

        $themes = get_themes();
        foreach ($themes as $theme) {
            // Theme sources.
            $themeSourcePath = system_path($this->moduleName, "resources/themes/{$theme->slug}");
            $dasboardComponentPath = "{$themeSourcePath}/portals/components";
            $frontendComponentPath = "{$themeSourcePath}/components";
            if (file_exists($dasboardComponentPath)) {
                Blade::anonymousComponentPath($dasboardComponentPath, "{$theme->slug}:portal");
            }
            if (file_exists($frontendComponentPath)) {
                Blade::anonymousComponentPath($frontendComponentPath, "{$theme->slug}:theme");
            }
        }

        // Portal sources.
        $adminPortalComponentPath = module_path($this->moduleName, 'resources/views/portals/components/');
        // $frontendComponentPath ="{$themeSourcePath}/components";
        if (file_exists($adminPortalComponentPath)) {
            Blade::anonymousComponentPath($adminPortalComponentPath, 'portal');
            Blade::anonymousComponentPath($adminPortalComponentPath, 'default:portal');
        }
        // Blade::anonymousComponentPath($frontendComponentPath, 'theme');

        // Fallback sources.
        // $defaultDashboardPath = module_path($this->moduleName, 'resources/views/components');
        $defaultFrontendPath = module_path($this->moduleName, 'resources/views/components/');
        // Blade::anonymousComponentPath($defaultDashboardPath, $this->moduleNameLower);
        if (file_exists($defaultFrontendPath)) {
            Blade::anonymousComponentPath($defaultFrontendPath, 'theme');
            Blade::anonymousComponentPath($defaultFrontendPath, 'default:theme');
        }

        Blade::component('dashboard-layout', Layout::class);
        Blade::component('frontend-layout', FrontendLayout::class);
        Blade::component('auth-layout', AuthenticationLayout::class);

        Gate::before(
            function ($user, $ability) {
                return $user->hasRole('Super Admin') ? true : null;
            }
        );

        $this->app->singleton(PerformanceMetric::class, function ($app) {
            return new PerformanceMetric();
        });

        $this->app->singleton(ResourceMonitor::class, function ($app) {
            return new ResourceMonitor($app->make(PerformanceMetric::class));
        });

        $kernel->prependMiddleware(InstallerValidMiddleware::class);
        $kernel->prependMiddleware(CookieConsentMiddleware::class);
        $router = $this->app['router'];
        if (alreadyInstalled() && checkDatabaseConnection()) {
            // $router->pushMiddlewareToGroup('web', PerformanceMonitor::class);
            $router->pushMiddlewareToGroup('web', BootstrapMiddleware::class);
            $router->aliasMiddleware('checkInstaller', LicenseActivationMiddleware::class);
            $router->aliasMiddleware('checkAuthCookie', \Modules\LMS\Http\Middleware\CheckAuthCookie::class);
        }
    }

    private function setupInitialState()
    {
        config([
            'lms.monitoring.init_time' => Carbon::now(),
            'lms.monitoring.user_context' => 'system'
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(FileServiceProvider::class);
        $this->app->register(CookieConsentServiceProvider::class);
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $sourcePath = module_path($this->moduleName, 'resources/views');
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePortalPath = module_path($this->moduleName, 'resources/views/portals');

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePortalPath]), "{$this->moduleNameLower}:portal");
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * Method registerGurads
     *
     * @return void
     */
    public function registerGurads()
    {

        Config::set(
            'auth.guards.admin',
            [
                'driver' => 'session',
                'provider' => 'admins',
                'hash' => true,
            ]
        );
        Config::set(
            'auth.providers.admins',
            [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ]
        );

        Config::set(
            'auth.guards.web',
            [
                'driver' => 'session',
                'provider' => 'users',
                'hash' => true,
            ]
        );

        Config::set(
            'auth.providers.users',
            [
                'driver' => 'eloquent',
                'model' => User::class,
            ]
        );
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {

        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * @return array<string>
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }

        return $paths;
    }

    /**
     * mailDriverSet
     */
    protected function mailDriverSet()
    {

        $mail = get_theme_option('mail_setting') ?? null;
        $config = array(
            'driver'     => $mail['mail_driver'] ?? null,
            'host'       => $mail['mail_host'] ?? null,
            'port'       => $mail['mail_port'] ?? null,
            'from'       => [
                'address' =>  $mail['mail_from_address'] ?? null,
                'name' => $mail['mail_from_name'] ?? null,
            ],
            'encryption' =>  $mail['mail_encryption'] ?? null,
            'username'   =>   $mail['mail_username'] ?? null,
            'password'   =>   $mail['password'] ?? null,
            'sendmail'   =>  '/usr/sbin/sendmail -bs',
            'pretend'    =>  false,
        );
        $backendSetting =  get_theme_option('backend_general') ?? null;

        if ($backendSetting) {
            config()->set('app.timezone', $backendSetting['time_zone'] ?? null);
            config()->set('lms.date_format', $backendSetting['date_format'] ?? null);
        }

        $cookie = get_theme_option('gdpr_cookie') ?? [];

        $cookieEnabled = $cookie['status'] ?? '';

        $cookieEnabled == 'on' ? config()->set('lms.cookie_enabled', true)
            : config()->set('lms.cookie_enabled', false);

        config()->set('mail', $config);


        if (App::environment('local')) {
            config()->set('lms.app_version', value: now());
        }
    }

    protected function paystackConfigure()
    {
        $paymentMethod =  PaymentMethod::where('method_name', 'paystack')->first();

        $secretKey = $paymentMethod->keys['secret_key'] ?? '';
        $publicKey = $paymentMethod->keys['public_key'] ?? '';
        $merchantEmail = $paymentMethod->keys['merchant_email'] ?? '';
        config()->set('paystack.secretKey',  $secretKey);
        config()->set('paystack.publicKey', $publicKey);
        config()->set('paystack.merchantEmail', $merchantEmail);
    }
}
