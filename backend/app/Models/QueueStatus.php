<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $id
 * @method static QueueStatus find($id)
 * @method static QueueStatus findOrFail($id)
 */
class QueueStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name','color'];
}
