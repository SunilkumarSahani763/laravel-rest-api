<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// MFA Routes
Route::get('mfa/verify', [LoginController::class, 'showMfaForm'])->name('mfa.verify');
Route::post('mfa/verify', [LoginController::class, 'verifyMfa']);

// Logout Route
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Route
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [LoginController::class, 'customerList'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard')->middleware('auth');

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/fetch-customers', [LoginController::class, 'customerList']);

Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

