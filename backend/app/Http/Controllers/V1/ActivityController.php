<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\Request;
use App\Models\Activity;

class ActivityController extends Controller
{

    public function index()
    {
        return api(Activity::query()->filter(request()->getFilters())->get());
    }


    public function store(ActivityCreateRequest $request)
    {

    }


    public function show(Activity $activity)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }
}
