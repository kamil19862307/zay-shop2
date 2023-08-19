<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;


Route::middleware('web')->group(function (){
    Route::get('/', HomeController::class)->name('home');

    Route::get('/storage/images/{dir}/{method}/{size}/{file}', ThumbnailController::class)
        ->where('method', 'resize|crop|fit')
        ->where('size', '\d+x\d+')
        ->where('file', '.+\.(jpg|png|bmp|gif|jpeg)$')
        ->name('thumbnail');



    Route::controller(AuthController::class)->group(function(){
       Route::get('/login', 'index')->name('logIn');
       Route::post('/login', 'signIn')->name('signIn');

       Route::get('/sign-up', 'signUp')->name('signUp');
       Route::post('/sign-up', 'store')->name('store');

       Route::get('/forgot-password', 'forgot')
           ->middleware('guest')
           ->name('password.request');

       Route::post('/forgot-password', 'forgotPassword')
           ->middleware('guest')
           ->name('password.email');

        Route::get('/reset-password/{token}', 'reset')
            ->middleware('guest')
            ->name('password.reset');

        Route::post('/reset-password/', 'resetPassword')
            ->middleware('guest')
            ->name('password.update');

        Route::delete('/logout', 'logOut')->name('logOut');
    });

});
