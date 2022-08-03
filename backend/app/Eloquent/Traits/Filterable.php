<?php

namespace App\Eloquent\Traits;

use App\Eloquent\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * @method static Builder|self filter(array $filters)
 */
trait Filterable
{
    private static array $filters = [
        'includes' => [],
        'fields'   => [],
        'sorts'    => [],
        'filters'  => []
    ];


    public function asFilter(array $filters = [], Request $request = null, $builder = null): Filter
    {
        return $this->filterBuilderChainMethods($this->getFilter($request, $builder), $filters);
    }


    private function filterBuilderChainMethods(Filter $filter, $filters = []): Filter
    {
        $filters = array_merge($this->getFilters(), $filters);

        return $filter->allowedFields($filters['fields'] ?? [])
            ->allowedIncludes($filters['includes'] ?? [])
            ->allowedFilters($filters['filters'] ?? [])
            ->allowedSorts($filters['sorts'] ?? []);
    }

    public function getFilter($request = null, $builder = null): Filter
    {
        return Filter::for($builder ?? $this, $this->createRequestForFilters($request));
    }

    protected function createRequestForFilters($request = null)
    {
        $request = $request ?? app(Request::class);

        return $this->requestFilterValueCasting($request);
    }

    public function requestFilterValueCasting($request)
    {
        if (property_exists($this, 'query_filter_casts')) {
            $values = $request->query->get('filter', []);

            foreach ($this->query_filter_casts as $key => $cast) {
                if (!empty($values[$key]) && !strpos($values[$key], ',')) {
                    $values[$key] = cast($values[$key], $cast);
                }
            }
            $request->query->set('filter', $values);
        }

        return $request;
    }

    public function scopeFilter($builder, $filters = []): Filter
    {
        return $this->filterBuilderChainMethods($this->getFilter(null, $builder), $filters);
    }


    public function getPassedIncludes($request): array
    {
        return array_intersect(
            explode(',', $request->get('include', '')),
            $this->getFilters()['includes'] ?? [],
        );
    }

    public function getFilters(): array
    {
        return self::$filters;
    }
}
