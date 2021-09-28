<?php


use App\Http\Controllers\V1\ActivityController;
use App\Http\Controllers\V1\ActivityItemController;
use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\DashboardController;
use App\Http\Controllers\V1\QueueController;
use App\Http\Requests\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('auth/login',[LoginController::class,'login']);

    Route::get('/time',function (Request $request){
        return now()->format($request->get('format','Y-m-d H:i:s'));
    });

    Route::get('/',function (){
        \App\Models\Queue::create([
            'detail' => []
        ]);
    });

    Route::middleware('auth:api')->group(function () {

        Route::get('dashboard',[DashboardController::class,'index']);


        Route::post('auth/refresh',[LoginController::class,'refresh']);
        Route::get('auth/user',[LoginController::class,'user']);
        Route::post('auth/logout',[LoginController::class,'logout']);


        Route::apiResource('activities', ActivityController::class);
        Route::apiResource('activity-items', ActivityItemController::class);

        Route::apiResource('queues', QueueController::class)
            ->middleware('contract:api')
            ->except(['show']);
        Route::get('queues/statuses', [QueueController::class,'statuses']);
    });

});
