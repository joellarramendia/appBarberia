<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('auth/login');
});


//admin
Route::get('/appointments/index', [AppointmentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/appointments/registeredClients', [UserController::class, 'index'])->name('appointments.registeredClients');


//mostrar los servicios
Route::get('/services/index', [ServiceController::class, 'index'])->middleware('auth');





Route::get('/appointments/store', [AppointmentController::class, 'store'])->middleware('auth');










Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
