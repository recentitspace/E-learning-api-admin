<?php

namespace Modules\LMS\Classes;

class InstalledFileManager
{
    /**
     * Create installed file.
     */
    public function create()
    {

        $installedLogFile = storage_path('installed');
        $dateStamp = date('Y/m/d h:i:sa');
        if (! file_exists($installedLogFile)) {
            $message = 'Laravel Installer successfully INSTALLED on '.$dateStamp."\n";
            file_put_contents($installedLogFile, $message);
        } else {
            $message = 'Laravel Installer successfully INSTALLED on '.$dateStamp;
            file_put_contents($installedLogFile, $message.PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        return $message;
    }

    /**
     * Update installed file.
     */
    public function update()
    {
        return $this->create();
    }
}
