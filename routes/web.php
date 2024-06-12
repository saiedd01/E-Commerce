<?php

use App\Http\Controllers\ArchiveProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'all']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware("is_admin", "auth")->group(function () {
    Route::controller(ProductController::class)->group(function () {

        Route::get("products", "all");
        Route::get("products/show/{id}", "show");

        Route::get("products/create", "create");
        Route::post("products", "store");

        Route::get("products/edit/{id}", "edit");
        Route::post("products/update/{id}", "update");

        Route::post("products/delete/{id}", "delete");

        Route::get("product/AllOrder", "allOrder");
        Route::get("products/OnTheWay/{id}", "onTheWay");
        Route::get("products/Delivered/{id}", "delivered");
        Route::post("products/Cancelled/{id}", "cancelled");

        Route::get("allUsers", "users");
        Route::get("user/orders/{id}", "userOrders");
    });
});

Route::middleware("is_admin", "auth")->group(function () {
    Route::controller(ArchiveProductController::class)->group(function () {

        Route::get("archive/products", "index");
        Route::get("archive/restore/{id}", "update");
        Route::post("archive/delete/{id}", "delete");
    });
});

Route::middleware("is_admin", "auth")->group(function () {
    Route::controller(CategoryController::class)->group(function () {

        Route::get("categories", "all");
        Route::get("categories/show/{id}", "show");

        Route::get("categories/create", "create");
        Route::post("categories", "store");

        Route::get("categories/edit/{id}", "edit");
        Route::post("categories/update/{id}", "update");

        Route::post("categories/delete/{id}", "delete");
    });
});


Route::get("user/product/show/{id}", [ProductController::class, 'show'])->name("Show");

Route::controller(HomeController::class)->group(function () {
    Route::get("redirect", "redirect");

    // all
    Route::get("user/product", "all");

    // show one
    Route::get("user/product/show/{id}", "show")->name("Show");


    // Search
    Route::get("search", "search");

    Route::middleware("auth", "verified")->group(function () {

        // Add to Cart
        Route::post("add_to_cart/{id}", "addToCart");

        // Cart Page
        Route::get("MyCart", "MyCart");

        // Edit in Cart Product
        Route::get("cart/edit/{id}", "editCart");

        // Update
        Route::post("cart/update/{id}", "updateCart");

        // Confirm Order
        Route::post("confirm_order", "Confirm_Order");

        //delete form cart
        Route::post("cart/delete/{id}", "delete_Cart");

        // Make review
        Route::post("submit_review","review");
        //logout
        Route::get("logout", "logout");
    });
});

Route::get("change/{lang}", function ($lang) {
    if ($lang == "ar") {
        session()->put("lang", "ar");
    } else {
        session()->put("lang", "en");
    }
    return redirect()->back();
});
