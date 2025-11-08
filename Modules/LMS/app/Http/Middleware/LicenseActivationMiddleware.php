<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class LicenseActivationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {

        $licenseKey = get_theme_option('license');
        $status = $licenseKey['status'] ?? [];
        if ($status !== true) {
            return Redirect::route('license.verify.form')->with('error', ' License not active');
        }
        return $next($request);
    }
}
