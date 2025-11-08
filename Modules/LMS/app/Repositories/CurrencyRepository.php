<?php

namespace Modules\LMS\Repositories;

use Modules\LMS\Models\Currency;

class CurrencyRepository extends BaseRepository
{
    protected static $model = Currency::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'currency' => 'required',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['_token', 'currency'],
        'update' => ['_token', '_method', 'currency'],
    ];

    /**
     * @param  int  $id
     * @return array
     */
    public function statusChange($id)
    {
        $response = parent::first($id);
        $currency = $response['data'];
        $currency->status = ! $currency->status;
        $currency->update();

        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully'),
        ];
    }
}
