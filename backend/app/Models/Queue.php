<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Models\Components\SafeLocationDataRegister;
use App\Models\Components\SetQueueNextNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Queue create(array $array)
 */
class Queue extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SafeLocationDataRegister;
    use SetQueueNextNumber;

    protected $fillable = [
        'location_id',
        'queueable_type',
        'queueable_id',
        'number',
        'started_at',
        'end_at',
        'missing_at',
        'type'
    ];

    protected $dates = [
        'started_at',
        'end_at',
        'missing_at',
    ];


    protected $casts = [
        'number' => 'int',
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'missing_at' => "datetime:Y-m-d H:i:s",
        'started_at' => "datetime:Y-m-d H:i:s",
        'end_at' => "datetime:Y-m-d H:i:s",
    ];

    const STARTED_AT = 'started_at';
    const MISSING_AT = 'missing_at';
    const END_AT     = 'end_at';

    const TYPES = [
        Activity::class,
        ActivityItem::class,
    ];


    public function queueable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function getNextNumber($queueable): int
    {
        return (int) Queue::query()
            ->select('number')
            ->where('queueable_type',$queueable)
            ->whereNull('missing_at')
            ->latest()
            ->whereRaw('DATE(created_at)=DATE(NOW())')
            ->value('number') + 1;
    }

    public static function getTypes(): array
    {
        return self::TYPES;
    }
}
