<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'area_id',
        'name',
        'price',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(related : Area::class);
    }

    public function contracts(): HasMany
    {
       return $this->hasMany(related: Contract::class);
    }


    public function activeContract(): HasMany
    {
        return $this->contracts()
            ->whereNotNull('expire_at')
            ->whereRaw('expire_date > NOW()')
            ->where('status',1)
            ->latest('expire_date')
            ->limit(value: 1);
    }


    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Activity::class,
            table: 'location_activity',
            foreignPivotKey: 'location_id',
            relatedPivotKey: 'activity_id'
        );
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','location_id');
    }
}
