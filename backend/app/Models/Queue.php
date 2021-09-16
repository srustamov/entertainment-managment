<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Models\Components\SafeLocationDataRegister;
use App\Models\Components\SetQueueNextNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Queue extends Model
{
    use HasFactory;
    use SafeLocationDataRegister;
    use SetQueueNextNumber;

    protected $fillable = [
        'location_id',
        'activity_id',
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
        'number' => 'int'
    ];

    const ACTIVITY_ITEM_TYPE = 1;
    const ACTIVITY_TYPE      = 2;

    const STARTED_AT = 'started_at';
    const MISSING_AT = 'missing_at';
    const END_AT     = 'end_at';


    public static function getNextNumber($activity,$type): int
    {
        if ($activity instanceof Activity) {
            $activity = $activity->id;
        }

        return (int) Queue::query()
            ->select('number')
            ->where('activity_id',$activity)
            ->whereNull('missing_at')
            ->where('type',$type)
            ->latest()
            ->whereRaw('DATE(created_at)=DATE(NOW())')
            ->value('number') + 1;
    }
}
