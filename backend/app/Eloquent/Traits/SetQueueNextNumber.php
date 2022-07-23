<?php

namespace App\Eloquent\Traits;


trait SetQueueNextNumber
{
    public static function bootSetQueueNextNumber()
    {
        static::creating(function ($queue) {

            $queue->number = static::getNextNumber($queue->queueable_type);

            $queue->status_id = $queue->status_id ?? 1;
        });
    }
}
