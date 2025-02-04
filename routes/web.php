<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\InboundSMSController;

Auth::routes();

Route::get('/', function () {

    if(Auth::check()) {

        if(Auth::user()->type == 'user'){

            return redirect()->route('userHome');

        } else if(Auth::user()->type == 'admin'){

            return redirect()->route('adminHome');

        }
    }

    return view('welcome');
});


Route::get('/sms/compose', [SMSController::class, 'showForm'])->name('sms.form');

Route::post('/send-sms', [SMSController::class, 'sendSMS'])->name('sms.send');


// User Side Routes
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/user/home', [HomeController::class, 'userHome'])->name('userHome');

});

// Admin Side Routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('adminHome');

});
