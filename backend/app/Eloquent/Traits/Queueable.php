<?php

namespace App\Eloquent\Traits;


use App\Models\Queue;
use Illuminate\Database\Eloquent\Relations\MorphMany;


trait Queueable
{
    public function queues(): MorphMany
    {
        return $this->morphMany(Queue::class,'queueable');
    }
}
