<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Models\Components\SafeLocationDataRegister;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $id
 * @method static ActivityItem find($id)
 * @method static ActivityItem findOrFail($id)
 */
class ActivityItem extends Model
{
    use HasFactory;
    use SafeLocationDataRegister;

    protected $table = 'activity_items';

    protected $fillable = [
        'activity_id',
        'name',
        'color',
        'number',
        'size',
        'price',
        'period',
    ];

    protected $casts = [
        'price' => 'double',
        'period' => 'double',
    ];

    protected $appends = ['period_unit'];


    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id');
    }


    public function getPeriodUnitAttribute()
    {
        return 'dəqiqə';
    }
}
