<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;


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


// User Side Routes
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/user/home', [HomeController::class, 'userHome'])->name('userHome');

});

// Admin Side Routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('adminHome');

});
