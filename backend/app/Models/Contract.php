<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Eloquent\Traits\HasLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasLocation;

    protected $table = 'location_contracts';

    protected $fillable = [
        'user_id',
        'start_date',
        'expire_date',
        'description',
        'price',
        'custom_data',
        'status',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'custom_data' => 'array',
        'status' => 'integer',
        'start_date' => 'date',
        'expire_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', 1);
    }
}
