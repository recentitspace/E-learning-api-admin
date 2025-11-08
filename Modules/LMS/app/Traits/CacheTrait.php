<?php

namespace Modules\LMS\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    public static function refreshForever($key, $value) {
        Cache::forget( $key);
        Cache::rememberForever($key, function() use($value) {
            return $value;
        });
    }
}