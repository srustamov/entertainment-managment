<?php

namespace App\Http\Controllers\V1;

use App\Components\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Queue;
use Carbon\CarbonInterval;

class DashboardController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index(Request $request): Api
    {
        $amount = Queue::query()
            ->selectRaw('SUM(price) as amount')
            ->join('queue_detail','queues.id','queue_detail.queue_id')
            ->where('queues.status_id',3)
            ->filter($request->getFilters())
            ->value('amount');

        $minutes = Queue::query()
            ->selectRaw('SUM(queue_detail.period) as minutes')
            ->join('queue_detail','queues.id','queue_detail.queue_id')
            ->where('queues.status_id',3)
            ->filter($request->getFilters())
            ->value('minutes') ?? 0;

        $minutes = CarbonInterval::minutes($minutes)->forHumans();

        $queues = Queue::query()
                   ->selectRaw('queue_statuses.name,queue_statuses.color,COUNT(queues.id) as count')
                   ->join('queue_statuses','queues.status_id','queue_statuses.id')
                   ->groupBy('status_id')
                   ->get();

        $count = $queues->sum('count');

        $queues->transform(function ($item) use ($count) {
           $item->percent =  ($item->count/$count)*100;

           return $item;
        });

        return api(compact('queues','minutes','amount'));

    }

}
