<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Client\BookingController;

// Import kontrolerów Rentala
use App\Http\Controllers\Rental\DashboardController as RentalDashboard;
use App\Http\Controllers\Rental\ProductController;
use App\Http\Controllers\Rental\CategoryController;
use App\Http\Controllers\Rental\BookingController as RentalBookingController;
use App\Http\Controllers\Rental\PaymentController;

// Import kontrolerów Admina
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;


// Strona główna z katalogiem produktów
Route::get('/', [HomeController::class, 'index'])->name('products.index');

Route::get('/dashboard', function () {
    
    if (auth()->check()) {
        if (auth()->user()->hasRole('SuperAdmin')) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->hasAnyRole(['RentalOwner', 'Employee'])) {
            return redirect()->route('rental.dashboard');
        }
    }
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth', 'role:Customer|SuperAdmin'])->group(function () {
    
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
    
});


Route::middleware(['auth', 'scope.rental', 'role:RentalOwner|Employee|SuperAdmin'])->prefix('rental')->name('rental.')->group(function () {
    Route::get('/dashboard', [RentalDashboard::class, 'index'])->name('dashboard');

    
    Route::middleware('permission:manage products')->group(function () {
        Route::resource('products', \App\Http\Controllers\Rental\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\Rental\CategoryController::class);
    });

    
    Route::middleware('permission:manage bookings|process payments')->group(function () {
        Route::resource('bookings', \App\Http\Controllers\Rental\BookingController::class);
        Route::resource('payments', \App\Http\Controllers\Rental\PaymentController::class)->only(['index', 'update']);
        Route::post('payments/{payment}/confirm', [\App\Http\Controllers\Rental\PaymentController::class, 'confirm'])->name('payments.confirm');
        Route::post('bookings/{booking}/payment', [\App\Http\Controllers\Rental\PaymentController::class, 'store'])->name('bookings.payment.store');
    });

    
});


Route::middleware(['auth', 'role:SuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    
    Route::resource('rentals', RentalController::class);
   
});


require __DIR__.'/auth.php';