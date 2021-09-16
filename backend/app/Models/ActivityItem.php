<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed $id
 */
class ActivityItem extends Model
{
    use HasFactory;

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


    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id');
    }


    public function getPeriodUnitAttribute()
    {
        return 'dəqiqə';
    }
}
