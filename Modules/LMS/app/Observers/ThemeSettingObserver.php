<?php

namespace Modules\LMS\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Traits\CacheTrait;

class ThemeSettingObserver
{
    use CacheTrait;
    /**
     * Handle the ThemeSetting "created" event.
     */
    public function created(ThemeSetting $themeSetting): void
    {
        static::refreshForever('options', $themeSetting->all()->keyBy('key'));
    }

    /**
     * Handle the ThemeSetting "updated" event.
     */
    public function updated(ThemeSetting $themeSetting): void
    {
        static::refreshForever('options', $themeSetting->all()->keyBy('key'));
    }

    /**
     * Handle the ThemeSetting "deleted" event.
     */
    public function deleted(ThemeSetting $themeSetting): void
    {
        static::refreshForever('options', $themeSetting->all()->keyBy('key'));
    }

    /**
     * Handle the ThemeSetting "restored" event.
     */
    public function restored(ThemeSetting $themeSetting): void
    {
        static::refreshForever('options', $themeSetting->all()->keyBy('key'));
    }

    /**
     * Handle the ThemeSetting "force deleted" event.
     */
    public function forceDeleted(ThemeSetting $themeSetting): void
    {
        static::refreshForever('options', $themeSetting->all()->keyBy('key'));
    }
}
