<?php

namespace Modules\Queue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Queue\database\factories\QueueFactory;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory(): QueueFactory
    {
        return QueueFactory::new();
    }
}
