<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Eloquent\Traits\Queueable;
use App\Eloquent\Traits\SafeLocationDataRegister;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property mixed $id
 * @property ActivityDetail $detail
 * @property string $name
 * @method static ActivityItem find($id)
 * @method static ActivityItem findOrFail($id)
 */
class ActivityItem extends Model
{
    use HasFactory;
    use SafeLocationDataRegister;
    use Queueable;

    protected $table = 'activity_items';

    protected $fillable = [
        'activity_id',
        'name'
    ];

    protected $with = ['detail'];

    protected $appends = ['model_type'];


    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class,'activity_id');
    }

    public function detail(): MorphOne
    {
        return $this->morphOne(ActivityDetail::class,'activitable');
    }

    public function getModelTypeAttribute(): string
    {
        return static::class;
    }

}
