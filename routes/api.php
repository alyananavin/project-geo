<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user', [UsersController::class, 'createUser']);
Route::get('/user/{userId}', [UsersController::class, 'getUserById']);
Route::patch('/user/{userId}', [UsersController::class, 'updateUserById']);

Route::post('/order', [OrderController::class, 'createOrder']);
Route::get('/order/user/{userId}', [OrderController::class, 'getUserOrders']);
