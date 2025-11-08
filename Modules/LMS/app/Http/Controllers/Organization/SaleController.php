<?php


namespace Modules\LMS\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $courseId = authCheck()?->organizationCourses?->pluck('id')->toArray() ?? null;
        $response = PurchaseRepository::paginate(
            15,
            relations: ['user.userable', 'course.instructors.userable', 'courseBundle'],
            options: [
                'whereIn' => ['course_id', $courseId]
            ]
        );
        $sales = $response['data'] ?? [];
        $reports = PurchaseRepository::authSalesReports();
        return view('portal::organization.financial.sale.index', compact('sales', 'reports'));
    }
}
