<?php

namespace App\Http\Controllers\V1;

use App\Components\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCreateRequest;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function index(Request $request): Api
    {
        return api(Activity::filter($request->getFilters())->get());
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
