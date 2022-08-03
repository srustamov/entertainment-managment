<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Eloquent\Traits\HasLocation;
use App\Eloquent\Traits\Queueable;
use App\Eloquent\Traits\SafeLocationDataRegister;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property mixed $id
 * @property int $location_id
 * @property string $name
 * @property ActivityDetail $detail
 *
 * @method static Activity find($id)
 */
class Activity extends Model
{
    use HasFactory;
    use SafeLocationDataRegister;
    use Queueable;
    use HasLocation;

    protected $table = 'activities';

    protected $fillable = [
        'location_id',
        'name',
    ];

    protected $with = ['items', 'detail'];

    protected $appends = ['model_type'];

    public function getFilters(): array
    {
        return [
            'includes' => [
                'items',
                'detail',
            ],
            'fields'   => [],
            'sorts'    => [
                'id',
                'name',
            ],
            'filters'  => [
                'name',
            ]
        ];
    }

    public function detail(): MorphOne
    {
        return $this->morphOne(ActivityDetail::class, 'activitable');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ActivityItem::class, 'activity_id');
    }

    public function getModelTypeAttribute(): string
    {
        return static::class;
    }
}
