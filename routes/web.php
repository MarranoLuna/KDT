<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bye_na', function () {
    return view('bye_not_allowed');
})->name('bye_na');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dni/{filename}', [CourierController::class, 'dni'])->name("see_dni");
    Route::post('/courier/validate', [CourierController::class, 'validate'])->name("validate_courier");
    Route::post('/courier/reject', [CourierController::class, 'reject'])->name("reject_courier");
});

Route::middleware([ AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
});
///Route::middleware(AdminMiddleware::class)->group(function () {


////});

require __DIR__ . '/auth.php';
