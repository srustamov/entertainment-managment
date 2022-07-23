<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityItemCreateRequest;
use App\Models\ActivityItem;
use App\Support\Api;
use Illuminate\Http\Request;

class ActivityItemController extends Controller
{

    public function index(Request $request): Api
    {
        return api(ActivityItem::filter($request->getFilters())
            ->paginate($request->get('itemsPerPage', 10)));
    }


    public function store(ActivityItemCreateRequest $request)
    {

    }


    public function show($id, Request $request): Api
    {
        return api(ActivityItem::filter($request->getFilters())
            ->where('id', $id)
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
