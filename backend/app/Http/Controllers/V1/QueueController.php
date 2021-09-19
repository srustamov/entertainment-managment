<?php

namespace App\Http\Controllers\V1;

use App\Components\Api;
use App\Http\Controllers\Controller;
use App\Models\QueueStatus;
use Illuminate\Http\Request;
use App\Models\Queue;


class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::query()
            ->select('queues.*')
            ->join('queue_statuses','queues.status_id','queue_statuses.id')
            ->orderBy('queue_statuses.sort','ASC')
            ->filter(request()->getFilters())
            ->paginate(request()->get('itemsPerPage',20));

        return api($queues);
    }


    public function statuses()
    {
        return api(QueueStatus::all());
    }


    public function store(Request $request): Api
    {
        $request->validate([
            'queueable_type' => ['required','string'],
            'queueable_id' => ['required','numeric'],
        ]);

        $queue = Queue::create([
            'queueable_type' => $request->post('queueable_type'),
            'queueable_id' => $request->post('queueable_id'),
        ]);

        $queue?->load(['queueable', 'status', 'detail']);

        return api($queue)->ok($queue);
    }

    public function show(Queue $queue): Api
    {
        return api($queue)->ok();
    }


    public function update(Queue $queue,Request $request)
    {
        $update = $queue->update($request->all());

        $queue?->load(['queueable','status','detail']);

        return api($queue)->ok($update)->toArray();
    }


    public function destroy($queue)
    {
        return api([])->ok(Queue::destroy($queue));
    }

}
