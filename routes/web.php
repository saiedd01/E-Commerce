<?php

use App\Http\Controllers\ArchiveProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
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
        // Route to display all products
        Route::get("products", "all");

        // Route to show a specific product by ID
        Route::get("products/show/{id}", "show");

        // Route to show the form to create a new product
        Route::get("products/create", "create");
        // Route to store a new product
        Route::post("products", "store");

        // Route to show the form to edit a product by ID
        Route::get("products/edit/{id}", "edit");
        // Route to update a product by ID
        Route::post("products/update/{id}", "update");

        // Route to delete a product by ID
        Route::post("products/delete/{id}", "delete");

        // Route to display all orders
        Route::get("product/AllOrder", "allOrder");

        // Route to mark an order as "On The Way" by order ID
        Route::get("products/OnTheWay/{id}", "onTheWay");
        // Route to mark an order as "Delivered" by order ID
        Route::get("products/Delivered/{id}", "delivered");
        // Route to cancel an order by order ID
        Route::post("products/Cancelled/{id}", "cancelled");

        // Show OrderDelivered Page
        Route::get("product/OrderDelivered", "OrderDelivered");

        // Show OnTheWayOrders Page
        Route::get("product/OrderOnTheWay", "OrderOnTheWay");

        // Show OrderInProgress Page
        Route::get("product/OrderInProgress", "OrderInProgress");

        // Route to display all users
        Route::get("allUsers", "users");
        // Route to display orders of a specific user by user ID
        Route::get("user/orders/{id}", "userOrders");

        // Route to search for a user by name
        Route::GET('search/user', 'SearchUser');
    });
});

Route::middleware("is_admin", "auth")->group(function () {
    Route::controller(ArchiveProductController::class)->group(function () {

        // Route to display archived products
        Route::get("archive/products", "index");

        // Route to restore an archived product by ID
        Route::get("archive/restore/{id}", "update");

        // Route to delete an archived product by ID
        Route::post("archive/delete/{id}", "delete");
    });
});

Route::middleware("is_admin", "auth")->group(function () {
    Route::controller(CategoryController::class)->group(function () {

        // Route to display all categories
        Route::get("categories", "all");
        // Route to show a specific category by ID
        Route::get("categories/show/{id}", "show");

        // Route to display form for creating a new category
        Route::get("categories/create", "create");
        // Route to store a new category
        Route::post("categories", "store");

        // Route to display form for editing a category by ID
        Route::get("categories/edit/{id}", "edit");
        // Route to update a category by ID
        Route::post("categories/update/{id}", "update");

        Route::post("categories/delete/{id}", "delete"); // Route to delete a category by ID

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

    // Sort
    Route::get("sort", "Sort");

    Route::middleware("auth", "verified")->group(function () {

        // Add to Cart
        Route::post("add_to_cart/{id}", "addToCart");

        // Cart Page
        Route::get("MyCart", "MyCart");

        // Edit in Cart Product
        Route::get("cart/edit/{id}", "editCart");

        // Update Cart
        Route::post("cart/update/{id}", "updateCart");

        //delete form cart
        Route::post("cart/delete/{id}", "delete_Cart");

        // Confirm Order
        Route::post("confirm_order", "Confirm_Order");

        // Make review
        Route::post("submit_review", "Review");

        //logout
        Route::get("logout", "logout");
    });
});


Route::middleware("verified", "auth")->group(function () {
    Route::controller(WishlistController::class)->group(function () {

        // Wishlist Page
        Route::get("wishlist", "index");

        // Add to Wishlist
        Route::post("add_to_wishlist/{id}", "addToWishlist");

        //delete form Wishlist
        Route::post("wishlist/delete/{id}", "delete_Wishlist");
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
