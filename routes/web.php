<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware('auth:sanctum');

Route::get('/login', function () {
    // User::create([
    //     'phone' => "0170000000",
    //     'password' => bcrypt("12345")
    // ]);
    return view('login');
})->name('login');

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('staff', [UserController::class, 'index']);
    Route::get('staff/{user}', [UserController::class, 'show']);
    Route::post('staff', [UserController::class, 'store']);
    Route::patch('staff/{user}', [UserController::class, 'update']);

    Route::patch('password/{user}', [PasswordController::class, 'update']);

    Route::get('customer', [CustomerController::class, 'index']);
    Route::post('customer', [CustomerController::class, 'store']);

});