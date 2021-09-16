<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Models\Components\SafeLocationDataRegister;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property mixed $id
 * @property int $location_id
 * @method static Activity find($id)
 */
class Activity extends Model
{
    use HasFactory;
    use SafeLocationDataRegister;

    protected $table = 'activities';

    protected $fillable = [
        'location_id',
        'name',
    ];


    public function items()
    {
        return $this->hasMany(ActivityItem::class,'activity_id');
    }


}
