<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\LMS\Models\Language;
use Modules\LMS\Models\Localization\Localization;
use Stevebauman\Location\Facades\Location;

class LocalizationMiddleware
{
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

        app()->singleton('default_language', function () use ($defaultLanguage) {
            return $defaultLanguage['code'] ?? App::getLocale();
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

        return $next($request);
    }
}
