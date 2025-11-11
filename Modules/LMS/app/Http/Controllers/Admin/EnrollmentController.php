<?php

namespace Modules\LMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\LMS\Enums\PurchaseType;
use App\Http\Controllers\Controller;
use Modules\LMS\Models\Enrollment;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;

class EnrollmentController extends Controller
{
    public function __construct(protected PurchaseRepository $purchase) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all enrollments with course and student details
        $enrollments = Enrollment::with([
            'student.userable',
            'course.category',
            'course.instructors.userable',
            'course.coursePrice',
            'course.courseSetting',
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('portal::admin.enrollment.index', compact('enrollments'));
    }

    public function create()
    {
        return view('portal::admin.enrollment.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function enrolled(Request $request)
    {
        // Check if the user has permission to edit the testimonial
        if (!has_permissions($request->user(), ['add.enrollment'])) {
            return json_error('You have no permission.');
        }
        // Attempt to update the testimonial
        $enrolled = $this->purchase->courseEnroll($request, $request->student_id);

        if ($enrolled['status'] !== 'success') {
            return response()->json($enrolled);
        }
        return $this->jsonSuccess('Enrolled Successfully!', route('enrollment.index'));
    }
    public function show($id)
    {
        $enrollment = $this->purchase->purchaseFirst($id);
        return view('portal::admin.enrollment.view', compact('enrollment'));
    }

    public function edit($id)
    {
        $enrollment = Enrollment::with(['student.userable', 'course'])->findOrFail($id);
        return view('portal::admin.enrollment.edit', compact('enrollment'));
    }

    public function update(Request $request, $id)
    {
        // Check if the user has permission
        if (!has_permissions($request->user(), ['edit.enrollment'])) {
            return json_error('You have no permission.');
        }

        // Validate request
        $validated = $request->validate([
            'student_id' => 'nullable|integer|exists:users,id',
            'organization_id' => 'nullable|integer|exists:users,id',
            'course_id' => 'required|integer|exists:courses,id',
            'course_title' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'course_status' => 'nullable|string|in:processing,completed,approved',
        ]);

        try {
            $enrollment = Enrollment::findOrFail($id);

            // Update only provided fields
            if ($request->has('student_id') && !empty($request->student_id)) {
                $enrollment->student_id = $validated['student_id'];
            }
            if ($request->has('organization_id')) {
                $enrollment->organization_id = $validated['organization_id'] ?: null;
            }
            // Always update course_id if provided (it's required)
            if ($request->has('course_id') && !empty($request->course_id)) {
                $enrollment->course_id = $validated['course_id'];
            }
            if ($request->has('course_title') && !empty($request->course_title)) {
                $enrollment->course_title = $validated['course_title'];
            }
            if ($request->has('price')) {
                $enrollment->price = $validated['price'] ?: 0;
            }
            if ($request->has('course_status') && !empty($request->course_status)) {
                $enrollment->course_status = $validated['course_status'];
            }

            $enrollment->save();

            return $this->jsonSuccess('Enrollment updated successfully!', route('enrollment.index'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_error('Enrollment not found.');
        } catch (\Exception $e) {
            return json_error('An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $enrollment = $this->purchase->delete($id);
        $enrollment['url'] = route('enrollment.index');
        return response()->json($enrollment);
    }

    /**
     * Approve enrollment (toggle course_status between processing and approved)
     */
    public function approve(Request $request, $id)
    {
        // Check if the user has permission
        $user = auth('admin')->user() ?? auth()->user();
        if (!$user || !has_permissions($user, ['edit.enrollment'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have no permission.'
            ], 403);
        }

        try {
            $enrollment = Enrollment::with('course')->findOrFail($id);
            $approved = $request->input('approved', 0);
            
            \Log::info('Enrollment approval request', [
                'enrollment_id' => $id,
                'approved' => $approved,
                'current_status' => $enrollment->course_status
            ]);

            // Set course_status based on switcher state
            if ($approved == 1) {
                // Approve: set to 'approved'
                $enrollment->course_status = 'approved';
                $message = 'Enrollment approved successfully!';
            } else {
                // Unapprove: set back to 'processing'
                $enrollment->course_status = 'processing';
                $message = 'Enrollment approval removed successfully!';
            }

            $enrollment->save();
            
            \Log::info('Enrollment updated', [
                'enrollment_id' => $id,
                'new_status' => $enrollment->course_status
            ]);

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'url' => route('enrollment.index')
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Enrollment not found.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Enrollment approval error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
