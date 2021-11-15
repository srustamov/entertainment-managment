<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $id
 * @method static Setting find($id)
 * @method static Setting findOrFail($id)
 */
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'key',
        'value'
    ];
}
