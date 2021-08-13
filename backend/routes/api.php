<?php


use Illuminate\Support\Facades\Route;


Route::post('auth/login',[LoginController::class,'login']);
Route::post('auth/refresh',[LoginController::class,'refresh']);
Route::get('auth/user',[LoginController::class,'user']);
Route::post('auth/logout',[LoginController::class,'logout']);

Route::get('/',function (){
   return api(collect(rand(1,20)));
});

Route::middleware('auth:api')->group(function () {

});
