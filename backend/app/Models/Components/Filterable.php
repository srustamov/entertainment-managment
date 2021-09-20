<?php

namespace App\Models\Components;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * @method static Builder|self filter(array $filters)
 */
trait Filterable
{
    public function scopeFilter(Builder $builder,array $filters): Builder
    {

        if (array_key_exists('sort',$filters)) {
            foreach ((array)$filters['sort'] as $column => $orderType) {
                if (in_array($column,$this->getFillable()) && in_array(strtoupper($orderType),['ASC','DESC'])) {
                    $builder->orderBy($column,$orderType);
                }
            }

            unset($filters['sort']);
        }

        if (array_key_exists('with',$filters)) {
            foreach ((array)$filters['with'] as $value) {
                [$relation,$value] = $this->parseRelationString($value);
                if ($this->isRelation($relation)) {
                    $builder->with($value);
                }
            }

            unset($filters['with']);
        }

        if (array_key_exists('select',$filters)) {
            foreach ((array)$filters['select'] as $column) {
                if (in_array($column,$this->getFillable())) {
                    $builder->addSelect($column);
                }
            }

            unset($filters['select']);
        }

        if (
            array_key_exists('trash',$filters) &&
            in_array(SoftDeletes::class, class_uses(static::class))
        ) {
            $builder->withTrashed();

            unset($filters['trash']);
        }


        if (array_key_exists('query',$filters)) {
            foreach ((array)$filters['query'] as $query) {
                if (in_array(count($query),[2,3])) {
                    if (count($query) == 2 && is_array($query[1])) {
                        $builder->whereIn(...$query);
                    } else {
                        $builder->where(...$query);
                    }
                }
            }

            unset($filters['query']);
        }

        if (isset($filters['withCount'])) {
            foreach ((array) $filters['withCount'] as $value) {
                [$relation,$value] = $this->parseRelationString($value);
                if ($this->isRelation($relation)) {
                    $builder->withCount($value);
                }
            }

            unset($filters['withCount']);
        }


        foreach ($this->getFillable() as $column) {
            if (array_key_exists($column,$filters)) {
                if (is_array($filters[$column]) && !empty($filters[$column])) {
                    $builder->whereIn($column,$filters[$column]);
                } elseif(!is_array($filters[$column])) {
                    $builder->where($column,$filters[$column]);
                }
            }
        }

        return $builder;

    }


    private function validColumn($column)
    {
        return in_array(Arr::last(explode('.',$column)),$this->getFillable());
    }

    private function parseRelationString(string $value): array
    {
        $relation = Arr::first(explode('.',$value));

        return [$relation,$value];
    }
}
