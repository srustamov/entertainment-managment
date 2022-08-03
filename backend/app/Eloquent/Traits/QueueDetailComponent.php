<?php

namespace App\Eloquent\Traits;

use App\Models\Queue;
use App\Models\QueueDetail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

use function collect;

/**
 * Trait QueueDetailComponent
 */
trait QueueDetailComponent
{
    public Collection $queue_detail;

    public static function bootQueueDetailComponent()
    {
        static::created(function (Queue $queue) {
            $queue->detail()->create([
                'price' => $queue->getQueueDetail()->get('price', $queue->queueable->detail->period_price),
                'period' => $queue->getQueueDetail()->get('period', $queue->queueable->detail->period),
                'description' => $queue->getQueueDetail()->get('description'),
            ]);
        });

        static::updated(function (Queue $queue) {
            if ($queue->getQueueDetail()->isNotEmpty()) {
                $queue->detail()->update([
                    'price' => $queue->getQueueDetail()->get('price', $queue->queueable->detail->period_price),
                    'period' => $queue->getQueueDetail()->get('period', $queue->queueable->detail->period),
                    'description' => $queue->getQueueDetail()->get('description'),
                ]);
            }
        });

        static::deleted(function (Queue $queue) {
            $queue->detail()->delete();
        });
    }

    public function detail(): HasOne
    {
        return $this->hasOne(QueueDetail::class, 'queue_id', 'id');
    }

    public function getEditableAttribute(): bool
    {
        return in_array($this->status_id, [1, 2]);
    }

    public function setDetailAttribute($value)
    {
        $this->queue_detail = collect((array) $value);
    }

    private function getQueueDetail(): Collection
    {
        return $this->queue_detail ?? collect([]);
    }
}
