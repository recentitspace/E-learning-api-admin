<?php

namespace Modules\LMS\Repositories;

use Modules\LMS\Models\General\NotificationTemplate;

class NotificationTemplateRepository extends BaseRepository
{
    protected static $model = NotificationTemplate::class;

    protected static $rules = [
        'save' => [
            'title' => 'required|string',
            'template_name' => 'required|string',
            'description' => 'required|string',
        ],
        'update' => [
            'title' => 'required|string',
            'template_name' => 'required|string',
            'description' => 'required|string',
        ],
    ];

    protected static $excludedFields = [
        'save' => ['_token'],
        'update' => ['_token', '_method'],
    ];
}
