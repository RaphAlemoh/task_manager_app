<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'XSS'], function () {
    Route::get('/migrate', function () {

        Artisan::call('migrate', [
            '--force' => true
        ]);

        Artisan::call('db:seed', [
            '--force' => true
        ]);

        return Artisan::output();
    });

    Route::get('{any}', function () {
        return view('welcome');
    })->where('any', '.*');

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
