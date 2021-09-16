<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\ActivityItem;

class ActivityItemController extends Controller
{


    public function index(Request $request)
    {
        return api(ActivityItem::query()->filter($request->getFilters())->paginate($request->get('per_page', 10)));
    }


    public function store(Request $request)
    {

    }


    public function show($id, Request $request)
    {
        return api(ActivityItem::query()
            ->where('id', $id)
            ->filter($request->getFilters())
            ->firstOrFail());
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
