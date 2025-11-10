<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MotorcycleBrandController;
use App\Http\Controllers\BicycleBrandController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;


Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/ion_login', [AuthenticatedSessionController::class, 'ion_store']);

Route::post('/register', [RegisteredUserController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::get('/bicycle-brands', [BicycleBrandController::class, 'index']);
Route::get('/motorcycle-brands', [MotorcycleBrandController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/requests/create', [RequestController::class, 'store']);
    Route::get('/requests', [RequestController::class, 'index']);
    Route::put('/requests/{request}', [RequestController::class, 'update']);
    Route::delete('/requests/{request}', [RequestController::class, 'destroy']);
    Route::get('/requests/available', [RequestController::class, 'availableForKdt']);
    Route::post('/requests/{request}/offers', [OfferController::class, 'store']);
    Route::get('/requests/{request}/offers', [RequestController::class, 'showOffers']);
    Route::post('/requests/{request}/offers/{offer}/accept', [RequestController::class, 'acceptOffer']);
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    Route::post('/courier/register', [CourierController::class, 'courierRegistration']);
    Route::post('/courier/toggle-status', [CourierController::class, 'toggleStatus']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/courier/active-order', [CourierController::class, 'getActiveOrder']);
    Route::post('/orders/{order}/complete', [OrderController::class, 'completeOrder']);
    Route::get('/orders/{order}/details', [OrderController::class, 'getDetails']);
    Route::get('/courier/my-orders', [CourierController::class, 'getMyOrders']);
    Route::get('/user/my-orders', [UserController::class, 'getMyOrders']);

    Route::get('/courier/order-history', [CourierController::class, 'getOrderHistory']);
    Route::get('/requests/available-count', [RequestController::class, 'getAvailableCount']);

    Route::post('/vehicles/register-bicycle', [VehicleController::class, 'storeBicycle']);
    Route::post('/vehicles/register-motorcycle', [VehicleController::class, 'storeMotorcycle']);

    Route::resource('users', UserController::class)->only([
        'show',   
        'update'  
    ]);
    
});


// Ruta para obtener los datos de un usuario por su ID
Route::get('/users/{user}', [UserController::class, 'show']);

// Ruta para actualizar los datos de un usuario por su ID
Route::put('/users/{user}', [UserController::class, 'update']); 

