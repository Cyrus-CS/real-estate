<?php

use App\Http\Controllers\Frontend\AgentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PropertyController as FrontendPropertyController;
use App\Http\Controllers\Frontend\RentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Home Page 
Route::get('/', [HomeController::class, 'index'])->name('home');

// Properties
Route::prefix('properties')->name('properties.')->group(function () {
    Route::get('/', [FrontendPropertyController::class, 'index'])->name('index');
    Route::get('/featured', [FrontendPropertyController::class, 'featured'])->name('featured');
    Route::get('/properties/{property}', [FrontendPropertyController::class, 'show'])->name('show');
});

// Rent - protégé, buyer uniquement
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/properties/{property}/rent', [RentController::class, 'store'])
        ->name('rents.store');
});

// Agents
Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
Route::get('/agents/{agent:id}', [AgentController::class, 'show'])->name('agents.show');

// Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// Services
Route::get('/valuation', [PageController::class, 'valuation'])->name('valuation');
Route::post('/valuation', [PageController::class, 'sendValuation'])->name('valuation.send');
Route::get('/mortgage-calculator', [PageController::class, 'mortgage'])->name('mortgage');

Route::middleware('auth')->group(function () {

    // Favorites
    Route::get('/favorites', [FrontendPropertyController::class, 'favorites'])->name('favorites');
    Route::post('/properties/{property}/favorite', [FrontendPropertyController::class, 'toggleFavorite'])->name('properties.favorite');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('breeze.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('breeze.profile.update');
    Route::put('/profile', [ProfileController::class, 'update'])->name('breeze.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('breeze.profile.destroy');
});

require __DIR__.'/dashboard.php';
require __DIR__.'/auth.php';