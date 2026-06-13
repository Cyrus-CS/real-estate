<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\RentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'dashboard.access', 'verified'])->prefix('dashboard')->name('admin.')->group(function() {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::resource('property', PropertyController::class)->except('show')->names('property');

    // Rent Applications
    Route::get('/applications', [RentController::class, 'index'])->name('applications.index');
    Route::put('/applications/{application}', [RentController::class, 'update'])->name('applications.update');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::put('/applications/{application}', [RentController::class, 'update'])->name('applications.update');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update'); // Route pour mettre à jour le profil
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/notifications', [SettingsController::class,
    'updateNotifications'])->name('settings.notifications.update');
    Route::post('/settings/preferences', [SettingsController::class,
    'updatePreferences'])->name('settings.preferences.update');

    // 2FA
    Route::get('/settings/2fa/setup', [SettingsController::class, 'show2FASetup'])
    ->name('settings.2fa.setup');
    Route::post('/settings/2fa/enable', [SettingsController::class, 'enable2FA'])->name('settings.2fa.enable');
    Route::post('/settings/2fa/confirm', [SettingsController::class, 'confirm2FA'])->name('settings.2fa.confirm');
    Route::post('/settings/2fa/disable', [SettingsController::class, 'disable2FA'])->name('settings.2fa.disable');
    Route::post('/settings/2fa/recovery-codes', [SettingsController::class,
    'regenerateRecoveryCodes'])->name('settings.2fa.recovery');


    // Routes réservées aux admins
    Route::middleware('admin')->group(function() {
        Route::resource('customers', CustomerController::class);
        Route::resource('agents', AgentController::class)->except(['show', 'create', 'edit']);
    });
});