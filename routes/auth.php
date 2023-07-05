<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'store')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::delete('/logout', 'destroy')->name('logout');
    // Route::get('/info', 'info')->name('info');
    Route::get('/refresh-token', 'refresh')->name('refresh');
});

Route::controller(OAuthController::class)->group(function () {
    Route::get('/redirect/google', 'google')->name('google');
    Route::get('/callback/google', 'google_callback')->name('google.callback');
    Route::get('/redirect/github', 'github')->name('github');
    Route::get('/callback/github', 'github_callback')->name('github.callback');
});
