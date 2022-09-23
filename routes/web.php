<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('authentication.login');
});


Route::prefix('authentication')->group(function(){
    Route::get('/', function(){
        return view('authentication.login');
    })->name('login');
    Route::get('/forgot-password', function(){
        return view('authentication.forgotpassword');
    })->name('forgot-password');
    Route::get('/register', function(){
        return view('authentication.register');
    })->name('register');
});