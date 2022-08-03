<?php

namespace App\Nova\Filters;

use App\Models\Area;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class AreaFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('area_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Area::all()->pluck('id', 'name')->toArray();
    }
}
