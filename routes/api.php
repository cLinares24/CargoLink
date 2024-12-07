<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransporterController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\ReviewController;

Route::apiResource('/users', UserController::class);
Route::apiResource('/clients', ClientController::class);
Route::apiResource('/transporters', TransporterController::class);
Route::apiResource('/vehicle', VehicleController::class);
Route::apiResource('/packages', PackageController::class);
Route::apiResource('/shipment', ShipmentController::class);
Route::apiResource('/pays', PayController::class);
Route::apiResource('/reviews', ReviewController::class);

Route::get('shipment/{shipment}/status', [ShipmentController::class, 'getStatus']);
Route::put('shipment/{shipment}/status', [ShipmentController::class, 'setStatus']);