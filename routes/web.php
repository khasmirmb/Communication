<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\InboundSMSController;
use Twilio\TwiML\MessagingResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

Route::post('/inbound-sms', [SmsController::class, 'receiveSms']); // Twilio webhook - doesn't need auth

// Protect routes with 'auth' middleware
Route::middleware(['auth'])->group(function () {

    Route::get('/sms/compose', [SmsController::class, 'showForm'])->name('sms.form');

    Route::post('/send-sms', [SmsController::class, 'sendSMS'])->name('sms.send');

    Route::get('/sms', [SmsController::class, 'showInbox'])->name('sms.inbox');
});


// User Side Routes
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/user/home', [HomeController::class, 'userHome'])->name('userHome');

});

// Admin Side Routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('adminHome');

});
