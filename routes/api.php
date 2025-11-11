<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BundleController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ForumController;
use App\Http\Controllers\API\InstructorController;
use App\Http\Controllers\API\EnrollmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public catalog routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);
Route::get('/instructors/{instructor}/courses', [CourseController::class, 'byInstructor']);
Route::get('/bundles', [BundleController::class, 'index']);
Route::get('/bundles/{bundle}', [BundleController::class, 'show']);

// Blog
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{blog}', [BlogController::class, 'show']);
Route::post('/blogs/{blog}/comments', [BlogController::class, 'comment']);

// Enrollments (public - no authentication required)
Route::get('/enrollments', [EnrollmentController::class, 'index']);
Route::post('/enrollments', [EnrollmentController::class, 'store']);
Route::put('/enrollments/{id}', [EnrollmentController::class, 'update']);
Route::patch('/enrollments/{id}', [EnrollmentController::class, 'update']);

// Forums
Route::get('/forums', [ForumController::class, 'index']);
Route::get('/forums/{forum}/posts', [ForumController::class, 'posts']);

// Instructors & user profile
Route::get('/instructors', [InstructorController::class, 'index']);
Route::get('/users/{id}/profile', [InstructorController::class, 'userProfile']);

// Authentication routes for external frontend (Next.js)
Route::prefix('auth')->group(function () {
    // Public login endpoint (no authentication required)
    Route::post('/login', [\Modules\LMS\Http\Controllers\Auth\LoginController::class, 'apiLogin']);
    
    // Get current authenticated user
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        $user = $request->user();
        
        // Check if user is admin (has name property) or regular user
        $isAdmin = isset($user->name) && !isset($user->username);
        
        if ($isAdmin) {
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name ?? null,
                    'user_type' => 'admin',
                    'guard' => 'admin',
                ]
            ]);
        }
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username ?? null,
                'user_type' => $user->guard ?? 'student',
                'guard' => $user->guard ?? 'student',
            ]
        ]);
    });
    
    // Logout endpoint
    Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    });
}); 