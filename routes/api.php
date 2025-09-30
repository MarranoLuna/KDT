<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;




Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/ion_login', [AuthenticatedSessionController::class, 'ion_store']);

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});



Route::middleware('auth:sanctum')->group(function () {

    Route::post('/requests', [RequestController::class, 'store']);
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);
});



// Ruta para obtener los datos de un usuario por su ID
///Route::get('/users/{user}', [UserController::class, 'show']);

// Ruta para actualizar los datos de un usuario por su ID
////Route::put('/users/{user}', [UserController::class, 'update']); 

