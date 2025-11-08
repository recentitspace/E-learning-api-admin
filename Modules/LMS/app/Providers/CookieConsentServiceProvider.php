<?php

namespace Modules\LMS\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\Middleware\EncryptCookies;

class CookieConsentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('theme::cookie.index', function ($view) {
            // ...
            $cookieConsentConfig = config('lms');
            $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);
            $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
        });

        $this->packageBooted();
    }

    public function packageBooted(): void
    {
        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('lms.cookie_name'));
        });
    }
}
