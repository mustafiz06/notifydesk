<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
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
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::put('/notifications', [ProfileController::class, 'updateNotifications'])->name('notifications.update');
    Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::delete('/avatar', [ProfileController::class, 'removeAvatar'])->name('avatar.remove');
});

// ========== Campaign Routes ==========
Route::prefix('campaigns')->name('campaigns.')->group(function () {
    Route::get('/', [CampaignController::class, 'index'])->name('index');
    Route::get('/create', [CampaignController::class, 'create'])->name('create');
    Route::post('/', [CampaignController::class, 'store'])->name('store');
    Route::get('/{campaign}', [CampaignController::class, 'show'])->name('show');
    Route::get('/{campaign}/edit', [CampaignController::class, 'edit'])->name('edit');
    Route::put('/{campaign}', [CampaignController::class, 'update'])->name('update');
    Route::delete('/{campaign}', [CampaignController::class, 'destroy'])->name('destroy');
    Route::get('/analytics', [CampaignController::class, 'analytics'])->name('analytics');
});

// ========== Message Routes ==========
Route::prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/create', [MessageController::class, 'create'])->name('create');
    Route::post('/', [MessageController::class, 'store'])->name('store');
    Route::get('/bulk', [MessageController::class, 'bulk'])->name('bulk');
    Route::post('/bulk', [MessageController::class, 'storeBulk'])->name('storeBulk');
    Route::get('/{message}', [MessageController::class, 'show'])->name('show');
    Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
});

// ========== Contact Routes ==========
Route::prefix('contacts')->name('contacts.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::get('/create', [ContactController::class, 'create'])->name('create');
    Route::post('/', [ContactController::class, 'store'])->name('store');
    Route::get('/import', [ContactController::class, 'import'])->name('import');
    Route::post('/import', [ContactController::class, 'storeImport'])->name('storeImport');
    Route::get('/groups', [ContactController::class, 'groups'])->name('groups');
    Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
    Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
    Route::put('/{contact}', [ContactController::class, 'update'])->name('update');
    Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
});

// ========== Analytics Routes ==========
Route::prefix('analytics')->name('analytics.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('index');
    Route::get('/reports', [AnalyticsController::class, 'reports'])->name('reports');
    Route::get('/performance', [AnalyticsController::class, 'performance'])->name('performance');
    Route::get('/export', [AnalyticsController::class, 'export'])->name('export');
});

// ========== API Keys Routes ==========
Route::prefix('api-keys')->name('api-keys.')->group(function () {
    Route::get('/', [ApiKeyController::class, 'index'])->name('index');
    Route::post('/', [ApiKeyController::class, 'store'])->name('store');
    Route::delete('/{apiKey}', [ApiKeyController::class, 'destroy'])->name('destroy');
});
