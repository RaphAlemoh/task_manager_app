<?php


use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'XSS'], function () {

    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
        Route::apiResource('tasks', TaskController::class);
        Route::get('/team/{team}/tasks', [TeamController::class, 'tasks']);
        Route::apiResource('teams', TeamController::class);
    });
});
