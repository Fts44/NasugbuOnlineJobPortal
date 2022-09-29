<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailerController as Mailer;
use App\Http\Controllers\OTPController as OTP;

use App\Http\Controllers\Authentication\RegisterController as Register;
use App\Http\Controllers\Authentication\RecoverController as Recover;
use App\Http\Controllers\Authentication\LoginController as Login;

use App\Http\Controllers\Employer\Profile as ProfileEmployer;

// start authentication route
Route::prefix('/')->group(function(){
    Route::get('login', [Login::class, 'index'])->name('LoginView');
    Route::post('login', [Login::class, 'login'])->name('Login');

    Route::get('recover', [Recover::class, 'index'])->name('RecoverView');
    Route::post('recover', [Recover::class, 'recover'])->name('Recover');
    Route::post('recover/otp', [OTP::class, 'compose_mail'])->name('RecoverSendOTP');

    Route::get('register', [Register::class, 'index'])->name('RegisterView');
    Route::post('register', [Register::class, 'register'])->name('Register');
    Route::post('register/otp', [OTP::class, 'compose_mail'])->name('RegisterSendOTP');
});
// end authentication route

// start main 
Route::prefix('/main')->group(function(){
    // start applicant 
    Route::prefix('/applicant')->group(function(){

    });
    // end applicant

    // start employer
    Route::prefix('/employer')->group(function(){
        Route::get('/', [ProfileEmployer::class, 'index'])->name('ProfileEmployerView');
    });
    // end employer
});
// end main 