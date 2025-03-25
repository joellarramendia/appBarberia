<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/createService', [ServiceController::class, 'createService']);
Route::get('/getService/{service_id}', [ServiceController::class, 'getService']);
Route::post('/updateService/{service_id}', [ServiceController::class, 'updateService']);
Route::delete('/deleteService/{service_id}', [ServiceController::class, 'deleteService']);



Route::post('/createAppointment', [AppointmentController::class, 'createAppointment']);
Route::delete('/deleteAppointments/{appointment_id}', [AppointmentController::class, 'destroy']);



Route::post('/appointments/checkAvailability', [AppointmentController::class, 'checkAvailability']);

Route::post('/appointments/{appointment_id}/confirm', [AppointmentController::class, 'confirmAppointment']);
