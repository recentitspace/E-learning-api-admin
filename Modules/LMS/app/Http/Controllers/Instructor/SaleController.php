<?php


namespace Modules\LMS\Http\Controllers\Instructor;

use Modules\LMS\Models\User;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = User::where('id', authCheck()->id)
            ->withWhereHas(
                'courses',
                function ($query) {
                    $query->where('organization_id', '=', null);
                }
            )
            ->first();
        $courseId = $user?->courses?->pluck('id')->toArray() ?? [];
        $response = PurchaseRepository::paginate(
            15,
            relations: ['user.userable', 'course.instructors.userable', 'courseBundle'],
            options: [
                'whereIn' => ['course_id', $courseId]
            ]
        );

        $sales = $response['data'] ?? [];
        $reports = PurchaseRepository::authSalesReports();
        return view('portal::instructor.financial.sale.index', compact('sales', 'reports'));
    }
}
