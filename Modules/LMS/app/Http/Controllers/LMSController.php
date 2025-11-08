<?php

namespace Modules\LMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('portal::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portal::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        return redirect('');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('portal::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('portal::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
        return redirect('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
