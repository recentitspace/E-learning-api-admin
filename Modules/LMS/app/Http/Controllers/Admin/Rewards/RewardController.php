<?php

namespace Modules\LMS\Http\Controllers\Admin\Rewards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Rewards\RewardRepository;

class RewardController extends Controller
{
    public function __construct(protected RewardRepository $reward) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rewards = $this->reward->get();

        return response()->json($rewards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $reward = $this->reward->save($request);

        return response()->json($reward);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
        $reward = $this->reward->first(value: $id);

        return response()->json($reward);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $reward = $this->reward->update($id, $request);

        return response()->json($reward);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $reward = $this->reward->first(value: $id);

        return response()->json($reward);
    }
}
