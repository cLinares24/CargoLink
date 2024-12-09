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

Route::apiResource('/packages', PackageController::class);
Route::apiResource('/pays', PayController::class);
Route::apiResource('/reviews', ReviewController::class);


//Shipments
Route::apiResource('/shipments', ShipmentController::class);
Route::get('/shipments/{shipment}/status', [ShipmentController::class, 'getStatus']);
Route::put('/shipments/{shipment}/status', [ShipmentController::class, 'setStatus']);
Route::get('/shipments/{shipment}/packages', [ShipmentController::class, 'getPackages']);
Route::get('/shipments/{shipment}/pay', [ShipmentController::class, 'getPay']);
Route::get('/shipments/{shipment}/review', [ShipmentController::class, 'getReview']);
Route::get('/shipments/status/{status}', [ShipmentController::class, 'indexByStatus']);

//Clients
Route::apiResource('/clients', ClientController::class);
Route::get('/client/{client}/shipments',[ClientController::class, 'getShipments']);

//Transporters
Route::apiResource('/transporters', TransporterController::class);
Route::get('/transporters/{transporter}/vehicles',[TransporterController::class, 'getVehicles']);
Route::get('/transporters/{transporter}/shipments',[TransporterController::class, 'getShipments']);

//Vehicles
Route::apiResource('/vehicles', VehicleController::class);
Route::get('/vehicles/type/{type}', [VehicleController::class, 'indexByTransportType']);

//Users
Route::apiResource('/users', UserController::class);
Route::get('/users/{user}/shipments', [UserController::class, "getShipments"]);

