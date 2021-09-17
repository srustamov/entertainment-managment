<?php

namespace App\Http\Controllers\V1;

use App\Components\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Queue;


class QueueController extends Controller
{
    public function index()
    {
        return api(Queue::query()
            ->filter(request()->getFilters())
            ->paginate(request()->get('per_page',20)));
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


        if ($queue) {
            $queue->load('queueable');
        }

        return api($queue)->ok($queue);
    }

    public function show(Queue $queue): Api
    {
        return api($queue)->ok();
    }


    public function update(Queue $queue,Request $request)
    {
        $update = $queue->update($request->all());

        return api($queue)->ok($update);
    }


    public function destroy($queue)
    {
        return api([])->ok(Queue::destroy($queue));
    }

    public function types()
    {
        return Queue::getTypes();
    }
}
