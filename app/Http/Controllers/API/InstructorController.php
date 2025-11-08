<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Models\User;

class InstructorController extends Controller
{
    /**
     * Public: list instructors with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;
        $page = (int) $request->query('page', 1);
        $search = trim((string) $request->query('search', ''));
        $countryId = $request->query('country_id');
        $stateId = $request->query('state_id');
        $cityId = $request->query('city_id');
        $locale = $request->query('locale');

        $query = Instructor::query()->with(['user', 'designation', 'country', 'state', 'city']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }
        if ($countryId) { $query->where('country_id', $countryId); }
        if ($stateId) { $query->where('state_id', $stateId); }
        if ($cityId) { $query->where('city_id', $cityId); }
        if ($locale) {
            $query->with(['translations' => function ($q) use ($locale) { $q->where('locale', $locale); }]);
        }

        $paginator = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function (Instructor $i) use ($locale) {
            $translation = null;
            if ($locale && $i->relationLoaded('translations')) {
                $translation = $i->translations->first();
            }
            $name = trim(($i->first_name ?? '').' '.($i->last_name ?? ''));
            $designation = $translation->designation ?? $i->designation->name ?? null;
            $bio = $translation->bio ?? $i->bio ?? null;

            // Count courses via the user morph relation and course_instructors pivot
            $coursesCount = 0;
            if ($i->relationLoaded('user') || $i->user) {
                $user = $i->user;
                if ($user) {
                    $coursesCount = $user->courses()->count();
                }
            }

            return [
                'id' => $i->id,
                'name' => $name !== '' ? $name : null,
                'username' => $i->user?->username,
                'email' => $i->user?->email,
                'designation' => $designation,
                'bio' => $bio,
                'avatar' => $i->image ?? null,
                'country' => $i->country?->name,
                'state' => $i->state?->name,
                'city' => $i->city?->name,
                'courses_count' => (int) $coursesCount,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    /**
     * Public: user profile view by user id (or instructor id via ?by=instructor)
     */
    public function userProfile(Request $request, $id): JsonResponse
    {
        $by = $request->query('by', 'user'); // 'user' or 'instructor'
        if ($by === 'instructor') {
            $instructor = Instructor::with(['user', 'designation', 'country', 'state', 'city'])->find($id);
            if (!$instructor) {
                return response()->json(['status' => 'error', 'message' => 'Instructor not found'], 404);
            }
            $name = trim(($instructor->first_name ?? '').' '.($instructor->last_name ?? ''));
            return response()->json(['status' => 'success', 'data' => [
                'id' => $instructor->id,
                'type' => 'instructor',
                'name' => $name !== '' ? $name : null,
                'username' => $instructor->user?->username,
                'email' => $instructor->user?->email,
                'designation' => $instructor->designation?->name,
                'bio' => $instructor->bio ?? null,
                'avatar' => $instructor->image ?? null,
                'country' => $instructor->country?->name,
                'state' => $instructor->state?->name,
                'city' => $instructor->city?->name,
                'socials' => $instructor->user?->socials?->map(fn($s) => [
                    'platform' => $s->platform ?? null,
                    'url' => $s->url ?? null,
                ])->values(),
            ]]);
        }

        $user = User::with(['userable', 'skills', 'socials'])->find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $name = $user->name ?? trim(($user->userable->first_name ?? '').' '.($user->userable->last_name ?? ''));
        return response()->json(['status' => 'success', 'data' => [
            'id' => $user->id,
            'type' => 'user',
            'name' => $name !== '' ? $name : null,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => $user->image ?? null,
            'skills' => $user->skills?->map(fn($s) => ['id' => $s->id, 'name' => $s->name ?? null])->values(),
            'socials' => $user->socials?->map(fn($s) => [
                'platform' => $s->platform ?? null,
                'url' => $s->url ?? null,
            ])->values(),
        ]]);
    }
} 