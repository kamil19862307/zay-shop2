<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');


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
