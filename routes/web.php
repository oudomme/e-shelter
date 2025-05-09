<?php

use App\Http\Controllers\Business\BusinessInformationController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Lang\SwichLanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;

//  Authentication 

Route::middleware('locale')->group(function (){  
    Route::prefix('auth')->group(function () {
        Route::middleware(['redirectIfAuthenticated'])->group(function (){
            Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
            Route::post('/register', [AuthController::class, 'register']);
        
            Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AuthController::class, 'login']);
        });
        
        Route::middleware(['auth'])->group(function(){
            Route::middleware(['redirectIfAuthenticated'])->group(function (){
                Route::get("/verify", [AuthController::class, 'verifyEmail'])->name('verify');
                Route::post("/verify", [AuthController::class, 'verifyEmailOTP'])->name('verify.otp');
                Route::post("/resend-otp", [AuthController::class, 'resendOTP'])->name('resendOTP');
            });
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        }); 
    });

    //  dashboard
    Route::middleware(['auth', 'verified.email'])->group(function (){
       
        Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard.index');
        
        Route::get('/business-information', [BusinessInformationController::class, 'index'])->name('business-information.index');

    });

    Route::post('lang', [SwichLanguageController::class, 'switchLang'])->name('lang.switch');

    // website

    Route::get("/", function (){
        return view('website.home');
    })->name('home');

    Route::get("/service", function (){
        return ;
    })->name('service');

    Route::get("/partner", function (){
        return ;
    })->name('partner');

    Route::get("/features", function (){
        return ;
    })->name('features');
});
