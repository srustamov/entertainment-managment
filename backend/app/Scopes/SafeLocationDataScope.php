<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SafeLocationDataScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($user = user()) {
            if (in_array('location_id', $model->getFillable())) {
                $builder->where($model->getTable().'.location_id', $user->location_id);
            }
//            elseif (in_array('activity_id',$model->getFillable())) {
//                $builder->whereIn(
//                    $model->getTable().'.activity_id',
//                    $user->location->activities()
//                );
//            }
        }
    }
}
