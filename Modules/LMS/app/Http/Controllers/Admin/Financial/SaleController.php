<?php

namespace Modules\LMS\Http\Controllers\Admin\Financial;

use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = PurchaseRepository::paginate(15, relations: ['user.userable', 'course.instructors.userable', 'courseBundle']);
        $sales = $response['data'] ?? [];
        $reports = PurchaseRepository::salesReports();
        return view('portal::admin.financial.sale.index', compact('sales', 'reports'));
    }


    public function invoice($id)
    {
        $response = PurchaseRepository::first($id, relations: ['user.userable', 'course.instructors.userable', 'courseBundle', 'course.organization.userable']);
        $invoice = $response['data'] ?? [];
        return view('portal::admin.financial.sale.invoice', compact('invoice'));
    }
}
