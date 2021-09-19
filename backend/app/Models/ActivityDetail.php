<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property mixed $id
 * @property mixed $period_price
 * @property double $period
 * @property string $color
 * @property string $size
 * @property string $number
 * @method static ActivityDetail find($id)
 * @method static ActivityDetail findOrFail($id)
 */
class ActivityDetail extends Model
{
    use HasFactory;

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

    public $timestamps  = false;

    protected $casts = [
        'period_price' => 'double',
        'period' => 'double',
    ];

    protected $appends = ['period_unit'];


    public function activitable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getPeriodUnitAttribute(): string
    {
        return 'dəqiqə';
    }
}
