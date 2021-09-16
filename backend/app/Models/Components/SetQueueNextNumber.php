<?php

namespace App\Models\Components;


trait SetQueueNextNumber
{
    public static function bootSetQueueNextNumber()
    {
        static::creating(function ($queue) {
            $queue->number = static::getNextNumber($queue->activity_id,$queue->type);
        });
    }
}
