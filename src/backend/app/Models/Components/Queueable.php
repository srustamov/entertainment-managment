<?php

namespace App\Models\Components;


use App\Models\Queue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;


trait Queueable
{
    public function queues()
    {
        return $this->morphMany(Queue::class,'queueable');
    }
}
