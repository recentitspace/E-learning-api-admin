<?php

namespace Modules\LMS\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\LMS\Repositories\Auth\UserRepository;

class LoginController extends Controller
{
    public function __construct(protected UserRepository $user) {}

    /**
     * Display a listing of the resource.
     */
    public function showForm()
    {
        // Check if the user is authenticated
        if (Auth::check() || auth::guard('admin')->check()) {
            // Retrieve the user's guard type
            $guard = authCheck()->guard ?? null;
            // Determine the redirect route based on the guard type
            // Admin and Instructor go to admin dashboard, Student goes to student dashboard
            $redirectRoute = match ($guard) {
                'instructor' => 'admin.dashboard',        // Instructor goes to admin dashboard
                'student' => 'student.dashboard',          // Student dashboard
                'organization' => 'organization.dashboard', // Organization dashboard
                default => 'admin.dashboard',             // Admin or default goes to admin dashboard
            };
            // Redirect to the matched route if available
            if ($redirectRoute) {
                return redirect()->route($redirectRoute);
            }
        }
        return view('theme::login.login');
    }

    /**
     * creating a new resource.
     */
    public function login(Request $request)
    {
        $result = $this->user->login($request);
        
        // If login is successful, return JSON response with cookies (no redirect)
        if ($result['status'] === 'success') {
            // Get redirect URL based on user type
            $userType = $result['user']['user_type'] ?? $result['user']['guard'] ?? 'student';
            
            // Determine redirect URL: admin/instructor → admin dashboard, student → student dashboard
            $redirectUrl = match($userType) {
                'admin', 'instructor' => route('admin.dashboard'),
                'student' => route('student.dashboard'),
                'organization' => route('organization.dashboard'),
                default => route('student.dashboard'),
            };
            
            // Update redirect_url in result (for consistency)
            $result['redirect_url'] = $redirectUrl;
            // Also add 'url' for compatibility with existing JavaScript form handlers
            $result['url'] = $redirectUrl;
            
            // Always return JSON response with cookies (no redirect)
            // Ensure user_info is in the response body (duplicate of user for compatibility)
            $result['user_info'] = $result['user']; // Add user_info to response body
            
            // Create JSON response with explicit headers
            $response = response()->json($result, 200)
                ->header('Content-Type', 'application/json')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
            
            // Set token cookie (expires in 1 hour / 60 minutes)
            $response->cookie('auth_token', $result['token'], 60, '/', null, false, true); // httpOnly = true for security
            
            // Set user info cookie (expires in 1 hour / 60 minutes)
            $response->cookie('user_info', json_encode($result['user']), 60, '/', null, false, false); // httpOnly = false so frontend can read it
            
            return $response;
        }
        
        // If login failed, return error as JSON
        return response()->json($result, 401)
            ->header('Content-Type', 'application/json');
    }

    /**
     * API login endpoint for external frontend (Next.js)
     * Returns JSON with token (no cookies, no redirect)
     */
    public function apiLogin(Request $request)
    {
        $result = $this->user->login($request);
        
        // Return JSON response for API calls
        if ($result['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'token' => $result['token'],
                'user' => $result['user'],
                'redirect_url' => $result['redirect_url'] ?? null,
            ], 200);
        }
        
        // Return error response
        return response()->json([
            'status' => 'error',
            'message' => $result['message'] ?? 'Login failed',
        ], 401);
    }
}
