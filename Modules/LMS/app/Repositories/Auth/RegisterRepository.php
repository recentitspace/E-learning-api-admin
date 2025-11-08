<?php

namespace Modules\LMS\Repositories\Auth;

use Illuminate\Support\Facades\Log;
use Modules\LMS\Repositories\Student\StudentRepository;
use Modules\LMS\Repositories\Instructor\InstructorRepository;
use Modules\LMS\Repositories\Organization\OrganizationRepository;

class RegisterRepository
{
    public function __construct(
        protected StudentRepository $student,
        protected InstructorRepository $instructor,
        protected OrganizationRepository $organization
    ) {}

    /**
     * userRegister
     *
     * @param  mixed  $request
     */
    public function userRegister($request): array
    {
        try {
            // Use match for better readability and strict type checking
            $response = match ($request->user_type) {
                'student' => $this->student->save($request),
                'instructor' => $this->instructor->save($request),
                'organization' => $this->organization->save($request),
                default => [
                    'status' => 'error',
                    'message' => translate('Invalid user type provided.'),
                ],
            };

            return $response;
        } catch (\Throwable $th) {
            // Log the exception message for troubleshooting
            Log::error('Error while processing the request: ' . $th->getMessage());

            // Return a detailed error response with the exception message
            return [
                'status' => 'error',
                'message' => translate('An error occurred while processing your request. Please try again later.'),
            ];
        }
    }
}
