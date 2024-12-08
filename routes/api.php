<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CompanyController; // Import the CompanyController
use Illuminate\Support\Facades\Route;

Route::post('token', [LoginController::class, 'login']);
Route::post('register', RegisterController::class,'register');

// Add route for company creation without authentication

Route::group(['middleware' => 'api.auth'], function () {
    Route::get('user', [LoginController::class, 'details']);
    Route::get('logout', [LoginController::class, 'logout']);

    Route::apiResource('product', ProductController::class);
    Route::apiResource('category', CategoryController::class);
    Route::post('verify-gst', [CompanyController::class, 'store']);

});


