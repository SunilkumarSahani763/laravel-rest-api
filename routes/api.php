<?php
use Laravel\Passport\Passport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerapiController;





Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:check')->group(function () {
Route::get('login', [AuthController::class, 'login']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::put('/users/{id}', [AuthController::class, 'update']);
Route::delete('/users/{id}', [AuthController::class, 'destroy']);

Route::post('/custom-api', [CustomController::class, 'store']);
});


Route::post('/customers', [CustomerapiController::class, 'store']);
Route::get('/customers', [CustomerapiController::class, 'index']);
Route::get('/customers/{id}', [CustomerapiController::class, 'show']);
Route::put('/customers/{id}', [CustomerapiController::class, 'update']);
Route::delete('/customers/{id}', [CustomerapiController::class, 'destroy']);
// Route::middleware('auth:sanctum')->group(function () {
// });



