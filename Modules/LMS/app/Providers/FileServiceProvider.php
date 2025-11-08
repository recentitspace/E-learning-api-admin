<?php

namespace Modules\LMS\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function boot(): void
    {
        //
        $this->registerStorage();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    protected function registerStorage()
    {
        $module = 'LMS';
        Config::set(
            'filesystems.disks.'.$module,
            [
                'driver' => 'local',
                'root' => module_path($module).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app',
                'url' => env('APP_URL').'/'.$module.'/storage',
                'visibility' => 'public',
                'throw' => false,
            ]
        );
    }
}
