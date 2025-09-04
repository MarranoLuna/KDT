<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

//Route::get('/posts', [PostController::class, 'index']);
//Route::post('/posts', [PostController::class, 'store']);
//Route::get('/posts/{post}', [PostController::class, 'show']);
//Route::put('/posts/{post}', [PostController::class, 'update']);
//Route::delete('/posts/{post}', [PostController::class, 'destroy']);

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
