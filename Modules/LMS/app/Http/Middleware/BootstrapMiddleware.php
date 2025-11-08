<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\LMS\Models\Language;
use Modules\LMS\Models\Localization\Localization;

use Stevebauman\Location\Facades\Location;


class BootstrapMiddleware
{
    protected string $moduleName = 'LMS';

    protected string $moduleNameLower = 'lms';

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $defaultLanguage = Language::select('code')->where('active', 1)->first();
        $locale = session()->get('locale') ?? $defaultLanguage['code'] ?? App::getLocale();
        $guard = null;

        if (Auth::check()) {
            $guard = 'web';
        }

        if (Auth::guard('admin')->check()) {
            $guard = 'admin';
        }

        if (! session()->has('locale')) {

            $localization = null;
            $user = Auth::guard($guard)->user();

            if ($user) {
                $localization = $user->localization;
            }

            if (! $user || ! $localization) {
                $ip = request()->ip();
                $fields['ip'] = $ip;
                $location = Location::get($ip);
                if ($location) {
                    $countryCode = strtolower($location->countryCode);
                    if ($countryCode) {
                        $fields['country_code'] = $countryCode;
                    }
                }

                $localization = Localization::where($fields)->first();
            }

            if ($localization) {
                $language = $localization->language;
                $locale = $defaultLanguage['code'] ?? $language->code ?? $locale;
            }
        }

        session()->put('locale', $locale);
        App::setLocale($locale);

        $this->registerSingletons($guard, $defaultLanguage);
        $this->registerViews();
        $this->registerBlades();

        return $next($request);
    }

    protected function registerSingletons($guard, $defaultLanguage)
    {
        $locale = App::getLocale();
        app()->singleton('translations', function () use ($locale) {
            return get_translations($locale);
        });

        app()->singleton('languages', function () {
            return Language::where('status', 1)
                ->get()
                ->map(function ($language) {
                    $language->name = translate($language->name);
                    return $language;
                });
        });

        app()->singleton('default_language', function () use ($defaultLanguage, $locale) {
            return $defaultLanguage['code'] ?? $locale;
        });

        app()->singleton('user', function () use ($guard) {
            return Auth::guard($guard ?? 'web')?->user() ?? null;
        });

        app()->singleton('user_roles', function () {
            $user = app('user');
            return $user ? $user->roles : [];
        });

        app()->singleton('user_permissions', function () {
            $user = app('user');
            return $user ? $user->user_permissions : [];
        });

        app()->singleton('user_role_list', function () {
            $user = app('user');
            return $user ? $user->roles->pluck('name')->toArray() : [];
        });
    }

    public function register_cache()
    {
        // Cache registration functionality removed for security
        // This method is now safe and contains no external dependencies
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        // Theme setup.
        $activeTheme = active_theme_slug();
        $activeThemeSourcePath = system_path($this->moduleName, "resources/themes/{$activeTheme}/views");
        $activePortalSourcePath = system_path($this->moduleName, "resources/themes/{$activeTheme}/portals");
        $sourcePath = module_path($this->moduleName, 'resources/views');
        $sourceThemePath = module_path($this->moduleName, 'resources/views/theme');
        $sourcePortalPath = module_path($this->moduleName, 'resources/views/portals');

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$activeThemeSourcePath, $sourceThemePath]), 'theme');

        if (file_exists($activePortalSourcePath)) {
            $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$activePortalSourcePath]), 'portal');
        }

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePortalPath]), 'portal');
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace') . '\\' . $this->moduleName . '\\' . ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    protected function registerBlades(): void
    {
        // Theme Settings
        $activeTheme = active_theme_slug();
        $activeThemeSourcePath = system_path($this->moduleName, "resources/themes/{$activeTheme}");

        // Theme sources.
        $activeThemeDasboardComponentPath = "{$activeThemeSourcePath}/portals/components";
        $activeThemeFrontendComponentPath = "{$activeThemeSourcePath}/components";

        if (file_exists($activeThemeDasboardComponentPath)) {
            Blade::anonymousComponentPath($activeThemeDasboardComponentPath, 'portal');
        }

        if (file_exists($activeThemeFrontendComponentPath)) {
            Blade::anonymousComponentPath($activeThemeFrontendComponentPath, 'theme');
        }

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
     * Register a view file namespace.
     *
     * @param  string|array  $path
     * @param  string  $namespace
     * @return void
     */
    protected function loadViewsFrom($path, $namespace)
    {
        $this->callAfterResolving('view', function ($view) use ($path, $namespace) {
            if (
                isset(app()->config['view']['paths']) &&
                is_array(app()->config['view']['paths'])
            ) {
                foreach (app()->config['view']['paths'] as $viewPath) {
                    if (is_dir($appPath = $viewPath . '/vendor/' . $namespace)) {
                        $view->addNamespace($namespace, $appPath);
                    }
                }
            }

            $view->addNamespace($namespace, $path);
        });
    }

    /**
     * Setup an after resolving listener, or fire immediately if already resolved.
     *
     * @param  string  $name
     * @param  callable  $callback
     * @return void
     */
    protected function callAfterResolving($name, $callback)
    {
        app()->afterResolving($name, $callback);

        if (app()->resolved($name)) {
            $callback(app()->make($name), app());
        }
    }


}
