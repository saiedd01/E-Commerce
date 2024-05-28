<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiProductController::class)->group(function () {
    Route::middleware("api_auth")->group(function (){
        // Get All Products
        Route::get("products", 'all');
        // Get Single Product By ID
        Route::get("products/{id}",'show');
        // Set Data
        Route::post("products",'store');
        // Update Data
        Route::put("products/update/{id}",'update');
        // Delete Data
        Route::delete("products/delete/{id}","delete");
    });
});

Route::controller(ApiAuthController::class)->group(function(){
    // register
    Route::post("/register", "register");
    //login
    Route::post("/login", "login");
    //logout
    Route::post("/logout", "logout");
});

