<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Queue;


class QueueController extends Controller
{
    public function index(Request $request)
    {
        return Queue::query()
            ->filter($request->getFilters())
            ->paginate($request->get('per_page',20));
    }
}
