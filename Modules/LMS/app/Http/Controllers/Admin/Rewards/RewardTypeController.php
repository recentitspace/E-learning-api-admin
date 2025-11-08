<?php

namespace Modules\LMS\Http\Controllers\Admin\Rewards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Rewards\RewardTypeRepository;

class RewardTypeController extends Controller
{
    public function __construct(protected RewardTypeRepository $rewardType) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rewardTypes = $this->rewardType->get();

        return response()->json($rewardTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rewardType = $this->rewardType->save($request);

        return response()->json($rewardType);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
        $rewardType = $this->rewardType->first(value: $id);

        return response()->json($rewardType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $rewardType = $this->rewardType->update($id, $request);

        return response()->json($rewardType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $rewardType = $this->rewardType->delete($id);

        return response()->json($rewardType);
    }
}
