<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'XSS'], function () {
    Route::get('/{any}', [HomePageController::class, 'index'])->where('any', '.*');
});
