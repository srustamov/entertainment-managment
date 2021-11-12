<?php

namespace App\Models\Components;

use App\Models\Activity;
use App\Scopes\SafeLocationDataScope;

trait SafeLocationDataRegister
{

    /** @noinspection PhpUndefinedFieldInspection */
    public static function bootSafeLocationDataRegister()
    {
        static::addGlobalScope(new SafeLocationDataScope);

        static::creating(function ($model) {

            if (auth('api')->check()) {

                if (in_array('location_id',$model->getFillable())) {
                    $model->location_id = auth('api')->user()->location_id;
                }

                if (in_array('user_id',$model->getFillable())) {
                    $model->user_id = auth('api')->user()->getAuthIdentifier();
                }

                if (in_array('activity_id',$model->getFillable())) {
                    if (auth('api')->user()->location_id != Activity::find($model->activity_id)->location_id) {
                        abort(403,'Seçilən fəaliyyət sizin əraziyə uyğun deyil');
                    }
                }
            }
        });
    }
}
