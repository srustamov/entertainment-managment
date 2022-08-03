<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Eloquent\Traits\HasLocation;
use App\Eloquent\Traits\QueueDetailComponent;
use App\Eloquent\Traits\SafeLocationDataRegister;
use App\Eloquent\Traits\SetQueueNextNumber;
use App\Services\QueueService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @method static Queue create(array $array)
 *
 * @property null|Carbon $started_at
 * @property null|Carbon $end_at
 * @property null|Carbon $missing_at
 * @property int $status_id
 * @property Activity|ActivityItem $queueable
 * @property Carbon $created_at
 * @property int $number
 * @property int $location_id
 * @property string $queueable_type
 * @property int $queueable_id
 * @property mixed $detail
 */
class Queue extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SafeLocationDataRegister;
    use SetQueueNextNumber;
    use HasLocation;

    /** @uses bootQueueDetailComponent() */
    use QueueDetailComponent;

    use LogsActivity;

    public const STARTED_AT = 'started_at';

    public const MISSING_AT = 'missing_at';

    public const END_AT = 'end_at';

    public const TYPES = [
        Activity::class,
        ActivityItem::class,
    ];

    protected $fillable = [
        'location_id',
        'queueable_type',
        'queueable_id',
        'number',
        'started_at',
        'end_at',
        'missing_at',
        'status_id',
        'updated_at',
        'detail',
    ];

    protected $dates = [
        //'started_at',
        //'end_at',
        //'missing_at',
    ];

    protected $casts = [
        'number' => 'int',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'missing_at' => 'datetime:Y-m-d H:i:s',
        'started_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'is_expired',
        'startable',
        'endable',
        'editable',
        'deletable',
    ];

    protected $with = ['status', 'detail'];


    public function getFilters(): array
    {
        return [
            'includes' => ['status', 'detail','queueable'],
            'fields'   => [],
            'sorts'    => [
                'number',
                'created_at',
                'updated_at',
                'started_at',
                'end_at',
                'missing_at',
            ],
            'filters'  => [
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('queueable_type'),
                AllowedFilter::exact('queueable_id'),
                AllowedFilter::exact('number'),
                AllowedFilter::exact('started_at'),
                AllowedFilter::exact('end_at'),
                AllowedFilter::exact('missing_at'),
            ]
        ];
    }

    public static function getNextNumber($queueable): int
    {
        return (int) Queue::query()
                ->select('number')
                ->where('queueable_type', $queueable)
                ->whereNull('missing_at')
                ->latest()
                ->whereRaw('DATE(created_at)=DATE(NOW())')
                ->value('number') + 1;
    }

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'number',
                'status.name',
                'queueable.name',
            ]);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QueueStatus::class, 'status_id', 'status');
    }

    public function queueable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getIsExpiredAttribute(): bool
    {
        return
            $this->started_at && ! $this->end_at &&
            Carbon::make($this->started_at)->addMinutes($this->detail->period)->lt(now());
    }

    public function getStartableAttribute(): bool
    {
        return $this->status_id == 1;
    }

    public function getDeletableAttribute(): bool
    {
        return $this->status_id == 1;
    }

    public function getEndableAttribute(): bool
    {
        return $this->status_id == 2;
    }

    /**
     * @throws Exception
     */
    public function print()
    {
        QueueService::make($this)->print();
    }
}
