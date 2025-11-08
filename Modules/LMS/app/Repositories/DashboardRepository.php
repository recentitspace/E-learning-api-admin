<?php

namespace Modules\LMS\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Category;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\Purchase\Purchase;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\SupportTicket\TicketSupport;
use Modules\LMS\Models\User;
use Modules\LMS\Repositories\Auth\UserRepository;

class DashboardRepository
{
    public function __construct(protected UserRepository $user) {}

    /**
     *  dashboardInfo
     *
     * @return array
     */
    public function dashboardInfo()
    {

        $data['top_category_courses'] = Category::whereHas('courses')->withCount('courses')->orderByDesc('courses_count')->get();
        $data['latest_supports'] = TicketSupport::with('user.userable.translations')->latest()->take(5)->get();
        $data['top_courses'] = Course::whereHas(relation: 'enrollments')
            ->with('courseSetting', 'coursePrice', 'instructors.userable')
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')->get();

        $data['total_instructor'] = $this->user->getUserByGuard('instructor')->count();
        $data['total_organization'] = $this->user->getUserByGuard('organization')->count();
        $data['total_student'] = $this->user->getUserByGuard('student')->count();
        $data['total_enrolled'] = PurchaseDetails::where('type', PurchaseType::ENROLLED)->get()->count();
        $data['total_amount'] = Purchase::sum('total_amount');
        $data['total_platform_fee'] = PurchaseDetails::sum('platform_fee');
        $data['total_courses'] = Course::count();
        $data['instructor_reports'] = $this->instructorRegisterByMonth();
        $data['student_reports'] = $this->studentRegisterByMonth();

        return $data;
    }

    /**
     * studentRegisterByMonth
     *
     * @return object
     */
    public function studentRegisterByMonth()
    {
        return $this->registerByUser(userType: 'student');
    }

    /**
     * instructorRegisterByMonth
     *
     * @return object
     */
    public function instructorRegisterByMonth()
    {
        return $this->registerByUser('instructor');
    }

    /**
     * instructorRegisterByMonth
     *
     * @param  string  $userType
     * @return object
     */
    public function registerByUser($userType)
    {
        return User::with('userable')->select(
            DB::raw('count(*) as total'),
            DB::raw("DATE_FORMAT(created_at,'%d %M %y') as  dayMonthYears")
        )
            ->where('guard', $userType)
            ->groupBy('dayMonthYears')
            ->get();
    }
}
