<?php

namespace App\Http\Controllers\V1;

use App\Components\Api;
use App\Http\Controllers\Controller;
use App\Models\QueueStatus;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class QueueController extends Controller
{
    public function index(Request $request): Api
    {
        dump($request->all());
        $queues = Queue::filter($request->getFilters())
            ->select('queues.*')
            ->join('queue_statuses','queues.status_id','queue_statuses.id')
            ->orderBy('queue_statuses.sort','ASC')
            ->paginate($request->get('itemsPerPage',20));

        return api($queues);
    }


    public function statuses(): Api
    {
        return api(QueueStatus::all());
    }


    public function store(Request $request): Api
    {
        $request->validate([
            'queueable_type' => ['required','string',Rule::in(Queue::TYPES)],
            'queueable_id' => ['required','integer'],
        ]);

        $queue = Queue::create($request->except(['location_id']));

        $queue?->load(['queueable', 'status', 'detail']);

        return api($queue)->ok($queue);
    }

    public function show(Queue $queue): Api
    {
        return api($queue)->ok();
    }


    public function update(Queue $queue,Request $request): Api
    {
        $update = $queue->update($request->all());

        $queue?->load(['queueable','status','detail']);

        return api($queue)->ok($update);
    }


    public function destroy($queue): Api
    {
        return api([])->ok(Queue::destroy($queue));
    }

}
