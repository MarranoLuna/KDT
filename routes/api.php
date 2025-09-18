<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;


Route::post('/requests', [RequestController::class, 'store']);
Route::get('/requests', [RequestController::class, 'index']);
Route::delete('/requests/{id}', [RequestController::class, 'destroy']);
Route::match(['put', 'patch'], 'requests/{id}', [RequestController::class, 'update']);


Route::get('/requests/user/{id}', [RequestController::class, 'getUserRequests']);

Route::get('/requests', [RequestController::class, 'index']);
Route::put('/requests/{id}', [RequestController::class, 'update']);   // o PATCH
Route::delete('/requests/{id}', [RequestController::class, 'destroy']);


Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/ion_login', [AuthenticatedSessionController::class, 'ion_store']);

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// Ruta para obtener los datos de un usuario por su ID
///Route::get('/users/{user}', [UserController::class, 'show']);

// Ruta para actualizar los datos de un usuario por su ID
////Route::put('/users/{user}', [UserController::class, 'update']); 

