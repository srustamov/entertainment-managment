<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\Request;
use App\Models\Activity;

class ActivityController extends Controller
{

    public function index(Request $request)
    {
        return Activity::query()->filter($request->getFilters())->paginate($request->get('per_page',10));
    }


    public function store(ActivityCreateRequest $request)
    {

    }


    public function show(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
