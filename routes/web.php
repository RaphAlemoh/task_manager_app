<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/migrate', function () {

    Artisan::call('migrate:fresh --seed', [
        '--force' => true
    ]);
    return Artisan::output();
});


Route::get('/{any}', [HomePageController::class, 'index'])->where('any', '.*');
