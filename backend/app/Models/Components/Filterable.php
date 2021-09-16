<?php

namespace App\Models\Components;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method Builder filter(array $filters)
 */
trait Filterable
{
    public function scopeFilter(Builder $builder,array $filters): Builder
    {
//        if (!method_exists(static::class,'filterable')) {
//            return $builder;
//        }

        if (array_key_exists('sort',$filters)) {
            foreach ((array)$filters['sort'] as $column => $orderType) {
                if (in_array($column,$this->getFillable()) && in_array(strtoupper($orderType),['ASC','DESC'])) {
                    $builder->orderBy($column,$orderType);
                }
            }
        }

        if (array_key_exists('with',$filters)) {
            foreach ((array)$filters['with'] as $relation) {
                if ($this->isRelation($relation)) {
                    $builder->with($relation);
                }
            }
        }


        if (array_key_exists('select',$filters)) {
            foreach ((array)$filters['select'] as $column) {

                if (in_array($column,$this->getFillable())) {
                    $builder->addSelect($column);
                }
            }
        }

        if (
            array_key_exists('trash',$filters) &&
            in_array(SoftDeletes::class, class_uses(static::class))
        ) {
            $builder->withTrashed();
        }

        if (array_key_exists('query',$filters)) {
            foreach ((array)$filters['query'] as $query) {
                if (in_array(count($query),[2,3]) && in_array($query[0],$this->getFillable())) {
                    $builder->where(...$query);
                }
            }
        }

        return $builder;

    }
}
