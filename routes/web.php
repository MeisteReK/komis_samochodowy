<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarSpecificationController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index']);


// Trasy dla ofert publicznych
Route::resource('offers', OfferController::class)->only(['index', 'show']);


// Trasy dla zarządzania ofertami (tylko dla zalogowanych i adminów)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('offers/create', [OfferController::class, 'create'])->name('offers.create');
    Route::post('offers', [OfferController::class, 'store'])->name('offers.store');
    Route::get('offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
    Route::put('offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
});

Route::get('offers/{offer}', [OfferController::class, 'show'])->name('offers.show')->where('offer', '[0-9]+');

// Trasy dla rezerwacji (tylko dla zalogowanych użytkowników)
Route::middleware('auth')->group(function () {
    Route::resource('reservations', ReservationController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('admin/reservations', [ReservationController::class, 'indexAdmin'])->name('reservations.index_admin');
    Route::patch('admin/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.update_status');
    Route::get('admin/reservations/process', [ReservationController::class, 'processReservations'])->name('reservations.process');
});

// Trasy dla użytkowników (tylko dla adminów)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
});

// Trasy uwierzytelniania
Auth::routes();

// Trasa do strony głównej
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/reservations/process', [ReservationController::class, 'processReservations'])->name('reservations.process')->middleware(['auth', 'admin']);
Route::get('reservations/total_cost/{userId}', [ReservationController::class, 'totalCost'])->name('reservations.total_cost')->middleware('auth');

