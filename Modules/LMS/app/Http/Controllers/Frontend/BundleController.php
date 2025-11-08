<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Courses\Bundle\BundleRepository;

class BundleController extends Controller
{
    public function bundleList()
    {
        $response = BundleRepository::paginate(10, $relations = [
            'category',
            'levels',
            'translations'
        ], $options = [
            'where' => ['status' => 1]
        ]);
        $bundles = $response['data'] ?? [];
        return view('theme::bundle.bundle-list', compact('bundles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function bundleDetail($slug)
    {
        $bundle = BundleRepository::bundleDetail($slug);

        $hasPurchase =  $bundle->hasUserPurchased(user: null);
        return view('theme::bundle.details', compact('bundle', 'hasPurchase'));
    }
}
