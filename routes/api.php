<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'XSS'], function () {

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('tasks', TaskController::class);
        Route::apiResource('teams', TeamController::class);
    });
});