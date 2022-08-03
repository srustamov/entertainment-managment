<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Location::class);
    }

    public function activities(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: Activity::class,
            through: Location::class
        );
    }
}
