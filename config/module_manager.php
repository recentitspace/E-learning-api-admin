<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Envato API Token
    |--------------------------------------------------------------------------
    |
    | This value is used to authenticate with Envato Market API.
    | You can generate a token from your Envato account.
    |
    */
    'envato_api_token' => env('ENVATO_API_TOKEN', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Marketplace API URL
    |--------------------------------------------------------------------------
    |
    | URL to your module marketplace API which returns a list of
    | available modules in JSON format.
    |
    */
    'marketplace_api_url' => env('MODULE_MARKETPLACE_URL', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Run database seeders after installation
    |--------------------------------------------------------------------------
    |
    | Determines whether to run the module's database seeders after installation.
    |
    */
    'run_seeders' => env('MODULE_RUN_SEEDERS', false),
    
    /*
    |--------------------------------------------------------------------------
    | Enable auto updates
    |--------------------------------------------------------------------------
    |
    | Automatically check for module updates and notify the admin.
    |
    */
    'enable_auto_updates' => env('MODULE_AUTO_UPDATES', true),
    
    /*
    |--------------------------------------------------------------------------
    | License verification schedule
    |--------------------------------------------------------------------------
    |
    | How often to verify module licenses (in days).
    |
    */
    'license_verification_interval' => env('LICENSE_VERIFICATION_INTERVAL', 30),
];
