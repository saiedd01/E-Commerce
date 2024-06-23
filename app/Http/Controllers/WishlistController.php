<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (Auth::id()) {
            // Get user and cart count
            $user = Auth::user();
            $user_id = $user->id;

            $countCart = User::getCartCount();

            $countWishlist = User::getWishlistCount();

            // Get user's Wishlist
            $items = Wishlist::where('user_id', "$user_id")->get();

            // Return view with carts and cart count
            return view("user.Wishlist", compact('items', "countCart","countWishlist", "user"));
        } else {
            // If not authenticated, redirect to login page
            return view("auth.login");
        }
    }
}
