<?php


use App\Http\Controllers\V1\ActivityController;
use App\Http\Controllers\V1\ActivityItemController;
use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\QueueController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('auth/login',[LoginController::class,'login']);

    Route::get('/',function (){

        auth('api')->setUser($user = User::find(1));

        return $user;

    });

    Route::middleware('auth:api')->group(function () {
        Route::post('auth/refresh',[LoginController::class,'refresh']);
        Route::get('auth/user',[LoginController::class,'user']);
        Route::post('auth/logout',[LoginController::class,'logout']);

        Route::apiResource('activities', ActivityController::class);
        Route::apiResource('activity-items', ActivityItemController::class);
        Route::apiResource('queues', QueueController::class);
    });

});
