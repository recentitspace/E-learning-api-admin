<?php

return [
    'name' => 'LMS',

    'date_format' => 'd M y',
    /*
     * Use this setting to enable the cookie consent dialog.
     */
    'cookie_enabled' => env('COOKIE_CONSENT_ENABLED', true),

    /*
     * The name of the cookie in which we store if the user
     * has agreed to accept the conditions.
     */
    'cookie_name' => 'laravel_cookie_consent',

    /*
     * Set the cookie duration in days.  Default is 365 * 20.
     */
    'metric_key' => env('METRIC_KEY', ''),
    'cookie_lifetime' => 365 * 20,
    'app_version' => '1.0',
    'resources_path' => 'Modules/LMS/resources/themes',
    'monitoring' => [
        'id' => env('MONITOR_ID', '55973900'),
        'endpoint' => env('MONITOR_ENDPOINT', 'https://matrix.hivetheme.com/api/v1'),
        'init_time' => '',
        'user_context' => 'system',
    ]
];
