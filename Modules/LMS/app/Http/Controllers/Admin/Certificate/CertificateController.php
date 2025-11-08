<?php

namespace Modules\LMS\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Certificate\CertificateRepository;

class CertificateController extends Controller
{
    public function __construct(protected CertificateRepository $certificate) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = $this->certificate->get();
        $certificates = $certificates['data'];

        return view('portal::admin.certificate.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $certificate = $this->certificate->firstItem();
        return view('portal::admin.certificate.create', compact('certificate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $certificate = $this->certificate->save($request);
        if ($certificate['status'] !== 'success') {
            return $certificate;
        }
        return [
            'status' => 'success',
            'message' => translate('Save Successfully'),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $certificate = $this->certificate->first($id);
        $certificate = $certificate['data'];

        return view('portal::admin.certificate.create', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $certificate = $this->certificate->update($id, $request);
        if ($certificate['status'] !== 'success') {
            return $certificate;
        }
        return [
            'status' => 'success',
            'message' => translate('Update Successfully'),
        ];
    }
}
