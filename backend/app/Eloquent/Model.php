<?php

namespace App\Eloquent;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method Builder filter()
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    public function scopeFilter(Builder $builder,array $filters)
    {
        if (!method_exists(static::class,'filterable')) {
            return $builder;
        }

        if (array_key_exists('sort',$filters)) {
            foreach ((array)$filters['sort'] as $column => $orderType) {
                if (in_array(strtolower($orderType),['ASC','DESC'])) {
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
                $builder->addSelect($column);
            }
        }

        if (array_key_exists('trash',$filters) && in_array(SoftDeletes::class, class_uses(static::class))) {
            $builder->withTrashed();
        }


        if (array_key_exists('query',$filters)) {
            foreach ((array)$filters['query'] as $query) {
                if (count($query) >= 2) {
                    $builder->where(...$query);
                }
            }
        }


        return $builder;

    }
}
