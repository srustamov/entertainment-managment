<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCreateRequest;
use App\Models\Activity;
use App\Support\Api;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request): Api
    {
        return api($this->useFilter(Activity::class, $request));
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
