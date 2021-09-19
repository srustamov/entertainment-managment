<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Models\Components\QueueDetailComponent;
use App\Models\Components\SafeLocationDataRegister;
use App\Models\Components\SetQueueNextNumber;
use App\Services\QueueService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @method static Queue create(array $array)
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
 */
class Queue extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SafeLocationDataRegister;
    use SetQueueNextNumber;
    use QueueDetailComponent;

    use LogsActivity;

    const STARTED_AT = 'started_at';
    const MISSING_AT = 'missing_at';
    const END_AT = 'end_at';
    const TYPES = [
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
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'missing_at' => "datetime:Y-m-d H:i:s",
        'started_at' => "datetime:Y-m-d H:i:s",
        'end_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = [
        'is_expired',
        'startable',
        'endable',
        'editable',
        'deletable'
    ];

    protected $with = ['status','detail'];

    public static function getNextNumber($queueable): int
    {
        return (int)Queue::query()
                ->select('number')
                ->where('queueable_type', $queueable)
                ->whereNull('missing_at')
                ->latest()
                ->whereRaw('DATE(created_at)=DATE(NOW())')
                ->value('number') + 1;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'number',
                'status.name',
                'queueable.name',
            ]);
    }

    public function status()
    {
        return $this->belongsTo(QueueStatus::class,'status_id');
    }


    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function queueable(): MorphTo
    {
        return $this->morphTo();
    }

//    public function getStatusAttribute()
//    {
//        if (!$this->started_at && !$this->missing_at) {
//            return $this->statuses[self::STATUS_NEW];
//        } elseif ($this->started_at && !$this->end_at && !$this->missing_at) {
//            return $this->statuses[self::STATUS_NOW];
//        } elseif (!$this->missing_at) {
//            return $this->statuses[self::STATUS_ENDED];
//        } else {
//            return $this->statuses[self::STATUS_MISSING];
//        }
//    }

    public function getIsExpiredAttribute()
    {
        return (
            $this->started_at &&
            !$this->ended_at &&
            Carbon::make($this->started_at)->addMinutes($this->queueable->detail->period) < now()
        );
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
