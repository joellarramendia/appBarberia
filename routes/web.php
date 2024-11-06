<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});


//admin
Route::get('/admin/appointments', function () {
    return view('admin.appointments');
});/*->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/admin/services', function () {
    return view('admin.services');
});

Route::get('/admin/registeredClients', function () {
    return view('admin.registeredClients');
});

//cliente
Route::get('/cliente', function () {
    return view('cliente.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
