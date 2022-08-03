<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $id
 *
 * @method static Log find($id)
 * @method static Log findOrFail($id)
 */
class Log extends Model
{
    use HasFactory;
}
