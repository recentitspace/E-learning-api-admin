<?php

namespace Modules\LMS\Repositories\Rewards;

use Modules\LMS\Models\Rewards\Reward;
use Modules\LMS\Repositories\BaseRepository;

class RewardRepository extends BaseRepository
{
    protected static $model = Reward::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'reward_type_id' => 'required',
            'points' => 'required',
        ],
        'update' => [
            'reward_type_id' => 'required',
            'points' => 'required',
        ],
    ];

    public static function save($request): array
    {

        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     * @return {array}
     */
    public static function update($id, $request): array
    {
        return parent::update($id, $request->all());
    }
}
