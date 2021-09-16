<?php

namespace App\Models\Components;

use App\Scopes\SafeLocationDataScope;

trait SafeLocationDataRegister
{
    public static function bootSafeLocationDataRegister()
    {
        static::addGlobalScope(SafeLocationDataScope::class);
    }
}
