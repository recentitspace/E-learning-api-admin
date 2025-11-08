<?php

namespace Modules\LMS\Repositories\General;

use Illuminate\Http\Request;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Models\General\EmailTemplate;

class EmailTemplateRepository extends BaseRepository
{
    protected static $model = EmailTemplate::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'subject' => 'required|string',
            'template_name' => 'required|string',
            'description' => 'required|string',
        ],
        'update' => [
            'subject' => 'required|string',
            'template_name' => 'required|string',
            'description' => 'required|string',
        ],
    ];

    protected static $excludedFields = [
        'save' => ['_token'],
        'update' => ['_token', '_method'],
    ];

    /**
     * @param  int  $id
     * @param Request $data
     */
    public static function update($id, $request): array
    {
        $emailTemplate = parent::update($id, $request->all());

        return $emailTemplate;
    }
}
