<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'XSS'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', function (Request $request){
            return $request->user();
        });
        Route::apiResource('tasks', TaskController::class);
        Route::apiResource('teams', TeamController::class);
    });
});