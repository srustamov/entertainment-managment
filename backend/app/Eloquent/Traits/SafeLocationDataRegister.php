<?php

namespace App\Eloquent\Traits;

use App\Models\Activity;
use App\Scopes\SafeLocationDataScope;
use function abort;
use function auth;
use function user;

trait SafeLocationDataRegister
{

    public static function bootSafeLocationDataRegister()
    {
        static::addGlobalScope(new SafeLocationDataScope);

        static::creating(function ($model) {

            if ($user = user()) {

                if (in_array('location_id',$model->getFillable())) {
                    $model->location_id = $user->location_id;
                }

                if (in_array('user_id',$model->getFillable())) {
                    $model->user_id = auth('api')->user()->getAuthIdentifier();
                }

                if (in_array('activity_id',$model->getFillable())) {
                    if ($user->location_id != Activity::find($model->activity_id)->location_id) {
                        abort(403,'You are not allowed to create this activity in this location');
                    }
                }
            }
        });
    }
}
