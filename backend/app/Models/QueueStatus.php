<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $id
 * @property string $locale
 *
 * @method static QueueStatus find($id)
 * @method static QueueStatus findOrFail($id)
 */
class QueueStatus extends Model
{
    use HasFactory;

    protected $fillable = ['locale', 'name', 'color'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $status) {
            if (! $status->locale) {
                $status->locale = app()->getLocale();
            }
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(function ($query) {
            $query->where('locale', app()->getLocale());
        });
    }
}
