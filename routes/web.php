<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddStockController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DueAdjustController;
use App\Http\Controllers\MedicineSearchController;
use App\Http\Controllers\PurchaseHistoryController;

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


    Route::prefix('staff')->group(function (){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::patch('/{user}', [UserController::class, 'update']);
    });

    Route::patch('password/{user}', [PasswordController::class, 'update']);
    Route::get('auth-user', [AuthUserController::class, 'index']);
    // Route::patch('user', [PasswordController::class, 'update_self']);
    // Route::patch('password', [PasswordController::class, 'update_self']);

    Route::prefix('customer')->group(function (){
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('/{customer}', [CustomerController::class, 'show']);
        Route::get('/phone/{phone}', [CustomerController::class, 'showPhone']);
        Route::post('/', [CustomerController::class, 'store']);
    });

    Route::prefix('supplier')->group(function (){
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/{supplier}', [SupplierController::class, 'show']);
        Route::get('/phone/{phone}', [SupplierController::class, 'showPhone']);
        Route::post('/', [SupplierController::class, 'store']);
    });


    Route::prefix('medicine')->group(function (){
        Route::get('/', [MedicineController::class, 'index']);
        Route::post('/', [MedicineController::class, 'store']);
        Route::get('/{medicine}', [MedicineController::class, 'show']);
        Route::patch('/{medicine}', [MedicineController::class, 'update']);
        Route::get('/search/{name}', [MedicineSearchController::class, 'show']);
    });

    Route::post('add-stock', [AddStockController::class, 'store']);

    Route::get('purchase-history', [PurchaseHistoryController::class, 'index']);
    Route::patch('purchase-history/{purchase_history}', [AddStockController::class, 'update']);

    Route::post('sell', [SellController::class, 'store']);
    // Route::get('profit', [ProfitController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::post('due-adjust/customer/{customer}', [DueAdjustController::class, 'customerDueAdjust']);
    Route::post('due-adjust/supplier/{supplier}', [DueAdjustController::class, 'supplierDueAdjust']);



});