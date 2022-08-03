<?php

namespace Laravel\Nova;

class TrashedStatus
{
    public const DEFAULT = '';

    public const WITH = 'with';

    public const ONLY = 'only';

    public static function fromBoolean($withTrashed)
    {
        return $withTrashed ? self::WITH : self::DEFAULT;
    }
}
