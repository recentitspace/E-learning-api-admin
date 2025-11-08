<?php

namespace Modules\LMS\Classes;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the form content to the .env file.
     *
     * @return string
     */
    public function saveFileWizard(Request $request)
    {

        $public = '';
        if (indexFile() != true) {
            $public = '/public';
        }
        $results = 'Your .env file settings have been saved.';
        $prefix = $request->database_prefix ? $request->database_prefix . '_' : '';
        $envFileData =
            'APP_NAME=\'' . $request->app_name . "'\n" .
            'APP_ENV=' . $request->environment . "\n" .
            'DB_TABLE_PREFIX=' . $prefix . "\n" .
            'APP_KEY=' . 'base64:' . base64_encode(Str::random(32)) . "\n" .
            'APP_DEBUG=' . $request->app_debug . "\n" .
            'APP_LOG_LEVEL=' . $request->app_log_level . "\n" .
            'APP_URL=' . $request->app_url . "\n\n" .
            'ASSET_URL=\'' . $request->app_url . $public . "'\n" .
            'DB_CONNECTION=' . $request->database_connection . "\n" .
            'DB_HOST=' . $request->database_hostname . "\n" .
            'DB_PORT=' . $request->database_port . "\n" .
            'DB_DATABASE=' . $request->database_name . "\n" .
            'DB_USERNAME=' . $request->database_username . "\n" .
            'DB_PASSWORD=' . $request->database_password . "\n\n" .
            'BROADCAST_DRIVER=' . 'log' . "\n" .
            'CACHE_DRIVER=' . 'file' . "\n" .
            'FILESYSTEM_DISK=' . 'local' . "\n" .
            'SESSION_DRIVER=' . 'file' . "\n" .
            'QUEUE_CONNECTION=' . 'database' . "\n" .
            'SESSION_LIFETIME=' . '120' . "\n\n" .
            'REDIS_HOST=' . '127.0.0.1' . "\n" .
            'REDIS_PASSWORD=' . 'null' . "\n" .
            'REDIS_PORT=' . '6379' . "\n\n" .
            'MAIL_DRIVER=' . 'smtp' . "\n" .
            'MAIL_HOST=' . 'mailpit' . "\n" .
            'MAIL_PORT=' . '1025' . "\n" .
            'MAIL_USERNAME=' . 'null' . "\n" .
            'MAIL_PASSWORD=' . 'null' . "\n" .
            'MAIL_ENCRYPTION=' . 'null' . "\n\n" .
            'PUSHER_APP_ID=' . '' . "\n" .
            'PUSHER_APP_KEY=' . '' . "\n" .
            'PUSHER_APP_SECRET=' . '' . "\n" .
            'DEFAULT_LANGUAGE=' . 'en' . "\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = 'Unable to save the .env file, Please create it manually.';
        }

        return $results;
    }
}
