<?php

namespace App\Models;

use App\Eloquent\Model;

/**
 * @property mixed $id
 *
 * @method static QueueDetail find($id)
 * @method static QueueDetail findOrFail($id)
 */
class QueueDetail extends Model
{
    protected $table = 'queue_detail';

    protected $fillable = [
        'queue_id',
        'price',
        'period',
        'description',
        'user_id',
    ];

    protected $casts = [
        'properties' => 'array',
    ];
}
