<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has valid session first
        $hasSession = Auth::check() || Auth::guard('admin')->check();
        
        // Check for auth token cookie
        $authToken = $request->cookie('auth_token');
        $userInfo = $request->cookie('user_info');
        
        // If no session AND no cookies, redirect to login
        if (!$hasSession && (!$authToken || !$userInfo)) {
            // Clear any invalid cookies
            Cookie::queue(Cookie::forget('auth_token'));
            Cookie::queue(Cookie::forget('user_info'));
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Session expired. Please login again.',
                    'redirect_url' => route('login')
                ], 401);
            }
            
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        
        // If has session but no cookies, set cookies from session (for existing sessions)
        if ($hasSession && (!$authToken || !$userInfo)) {
            $user = Auth::guard('admin')->check() ? Auth::guard('admin')->user() : Auth::user();
            $guard = Auth::guard('admin')->check() ? 'admin' : 'web';
            
            if ($user) {
                // Get existing token or create new one
                $tokenName = 'auth_token';
                $existingToken = $user->tokens()->where('name', $tokenName)->where('expires_at', '>', now())->first();
                
                if ($existingToken) {
                    // Token exists, but we need the plain text token
                    // Since we can't retrieve plain text, we'll create a new one and delete old ones
                    $user->tokens()->where('name', $tokenName)->delete();
                    $token = $user->createToken($tokenName, ['*'], now()->addHours(1))->plainTextToken;
                } else {
                    $token = $user->createToken($tokenName, ['*'], now()->addHours(1))->plainTextToken;
                }
                
                $userData = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'user_type' => $guard === 'admin' ? 'admin' : ($user->guard ?? 'student'),
                    'guard' => $guard,
                ];
                
                if ($guard === 'admin') {
                    $userData['name'] = $user->name ?? null;
                } else {
                    $userData['username'] = $user->username ?? null;
                }
                
                $response = $next($request);
                $response->cookie('auth_token', $token, 60, '/', null, false, true);
                $response->cookie('user_info', json_encode($userData), 60, '/', null, false, false);
                
                return $response;
            }
        }
        
        return $next($request);
    }
}

