<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\RequestController;


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
