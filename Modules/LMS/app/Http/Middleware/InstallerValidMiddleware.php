<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallerValidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();

        if (! alreadyInstalled()) {
            if ($path === 'install' || $path == 'install/requirements' || $path == 'install/permission' || $path == 'install/demo' || $path == 'install/environment' ||  $path == 'install/license' || $path == 'install/purchase-code' || $path == 'install/import-demo' || $path == 'install/database' || $path == 'install/final' || $path == 'localhost/*') {

                return $next($request);
            }

            return Response()->view('lms::installer.index');
        } else {
            if ($path === 'install' || $path == 'install/requirements' || $path == 'install/permission') {
                return redirect('404');
                // return $next($request);
            }
        }

        return $next($request);
    }
}
