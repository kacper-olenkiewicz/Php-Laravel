<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Client\ProductList;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Rental\DashboardController as RentalDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;


Route::get('/', ProductList::class)->name('products.index');
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
    Route::get('/dashboard', RentalDashboard::class)->name('dashboard');

    
    Route::middleware('permission:manage products')->group(function () {
        Route::resource('products', \App\Http\Controllers\Rental\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\Rental\CategoryController::class);
    });

    
    Route::middleware('permission:manage bookings|process payments')->group(function () {
        Route::resource('bookings', \App\Http\Controllers\Rental\BookingController::class);
        Route::resource('payments', \App\Http\Controllers\Rental\PaymentController::class)->only(['index', 'update']);
    });

    
});


Route::middleware(['auth', 'role:SuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

    
    Route::resource('rentals', RentalController::class);
   
});


require __DIR__.'/auth.php';