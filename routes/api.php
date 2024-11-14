<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/createService', [ServiceController::class, 'createService']);
Route::delete('/deleteService/{service_id}', [ServiceController::class, 'deleteService']);
Route::put('/updateService/{service_id}', [ServiceController::class, 'updateService']);