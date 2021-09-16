<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Models\Components\SafeLocationDataRegister;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;
    use SafeLocationDataRegister;

    protected $table = 'activities';

    protected $fillable = [
        'name'
    ];


    public function items()
    {
        return $this->hasMany(ActivityItem::class,'activity_id');
    }


}
