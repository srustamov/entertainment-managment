<?php

namespace App\Nova\Filters;

use App\Models\Activity;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ActivityFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('activity_id', $value);
    }

    public function options(Request $request)
    {
        return Activity::without('detail')->get(['id', 'name'])->pluck('id', 'name')->toArray();
    }
}
