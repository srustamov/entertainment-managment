<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property mixed $id
 * @property mixed $period_price
 * @property float $period
 * @property string $color
 * @property string $size
 * @property string $number
 *
 * @method static ActivityDetail find($id)
 * @method static ActivityDetail findOrFail($id)
 */
class ActivityDetail extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'activity_detail';

    protected $fillable = [
        'activitable_model',
        'activitable_id',
        'color',
        'number',
        'size',
        'period_price',
        'period',
    ];

    public $timestamps = false;

    protected $casts = [
        'period_price' => 'double',
        'period' => 'double',
    ];

    protected $appends = ['period_unit', 'images'];

    protected $with = ['media'];

    public function activitable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getImagesAttribute()
    {
        $images = [];

        foreach ($this->media ?? [] as $media) {
            $media->url = $media->getFullUrl();

            $images[] = $media;
        }

        unset($this->media);

        return empty($images) ? null : $images;
    }

    public function getPeriodUnitAttribute(): string
    {
        return 'dəqiqə';
    }
}
