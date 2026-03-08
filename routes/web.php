<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
        Route::resource('/', ProfileController::class)->only(['index', 'edit', 'update'])->parameter('', 'profile');    
});