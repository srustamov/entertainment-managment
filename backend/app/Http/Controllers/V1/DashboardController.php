<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Support\Api;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Api
    {
        $query = function () use ($request) {
            return $this->useFilter(Queue::class, $request)
                ->without(['status', 'detail'])
                ->when(count($request->get('date', [])), function ($query) use ($request) {
                    $query->whereBetween(DB::raw('DATE(queues.created_at)'), $request->get('date'));
                });
        };

        $amount = $query()
            ->selectRaw('SUM(price) as amount')
            ->join('queue_detail', 'queues.id', 'queue_detail.queue_id')
            ->where('queues.status_id', 3)
            ->value('amount');

        $minutes = $query()
                ->selectRaw('SUM(queue_detail.period) as minutes')
                ->join('queue_detail', 'queues.id', 'queue_detail.queue_id')
                ->where('queues.status_id', 3)
                ->value('minutes') ?? 0;

        $minutes = CarbonInterval::minutes($minutes)->forHumans();

        $queues = $query()
            ->without(['status', 'detail'])
            ->selectRaw('queue_statuses.name,queue_statuses.color,COUNT(queues.id) as count')
            ->join('queue_statuses', 'queues.status_id', 'queue_statuses.id')
            ->groupBy('status_id')
            ->get();

        $count = $queues->sum('count');

        $queues->transform(function ($item) use ($count) {
            $item->percent = ($item->count / $count) * 100;

            return $item;
        });

        return api(compact('queues', 'minutes', 'amount'));
    }
}
