<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        // Check user role
        if (Auth::user()->role == 1) {
            // If admin, redirect to admin dashboard
            return view("admin.all");
        } else {
            // If user, show products
            $products = Product::paginate(6);
            // Check if user is authenticated
            if (Auth::id()) {
                // Get user and cart count
                $user = Auth::user();
                $user_id = $user->id;
                $count = Cart::where("user_id", $user_id)->count();
            } else {
                // If not authenticated, set count to 0
                $count = 0;
            }
            // Return view with products and cart count
            return view("user.all", compact("products", "count"));
        }
    }

    // all
    public function all()
    {
        // Get all products
        $products = Product::paginate(6);
        // Check if user is authenticated
        if (Auth::id()) {
            // Get user and cart count
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
        } else {
            // If not authenticated, set count to 0
            $count = 0;
        }
        // Return view with products and cart count
        return view("user.all", compact("products", "count"));
    }

    public function show($id)
    {
        // Find product by ID
        $product = Product::findOrFail($id);
        // Check if user is authenticated
        if (Auth::id()) {
            // Get user and cart count
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
        } else {
            // If not authenticated, set count to 0
            $count = 0;
        }
        // Return view with product and cart count
        return view("user.show", compact("product", "count"));
    }

    public function search(Request $request)
    {
        // Check if user is authenticated
        if (Auth::id()) {
            // Get user and cart count
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
        } else {
            // If not authenticated, set count to 0
            $count = 0;
        }
        // Get search key from request
        $search = $request->key;
        // Search products by name
        $products = Product::where("name", 'like', "%$search%")->paginate(3);
        // Check if products found
        if ($products->isEmpty()) {
            // If no products found, flash error message and redirect back
            session()->flash('error', 'Product Not Found');
            return redirect()->back();
        } else {
            // If products found, return view with products
            return view("user.all", compact("products","count"));
        }
    }

    public function addToCart(Request $request, $id)
    {
        // Find product by ID
        $product_id = Product::findOrFail($id);
        // Get user ID
        $user = Auth::user();
        $user_id = $user->id;
        // Create new cart item
        $data = new Cart();
        $data->product_id = $product_id->id;
        $data->user_id = $user_id;
        $data->quantity = $request->quantity;
        // Calculate total price
        if ($product_id->Discount != 0.00) {
            $priceAfterDiscount = $product_id->price - $product_id->Discount;
            $data->total = $priceAfterDiscount * $request->quantity;
        } else {
            $data->total = $product_id->price * $request->quantity;
        }
        // Save cart item
        $data->save();
        // Flash success message and redirect back
        session()->flash("success", "Add product to Cart Successfully");
        return redirect()->back();
    }

    public function MyCart()
    {
        // Check if user is authenticated
        if (Auth::id()) {
            // Get user and cart count
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
            // Get user's carts
            $carts = Cart::where('user_id', "$user_id")->get();
            // Return view with carts and cart count
            return view("user.Cart", compact('carts', "count","user"));
        } else {
            // If not authenticated, redirect to login page
            return view("auth.login");
        }
    }

    public function Confirm_Order(Request $request)
    {
        $data = $request->validate([
            "phone" => "required|string|regex:/^[0-9]{11,15}$/",
            "address"=>"required|string|max:255",
        ],[
            "phone.required" => "Please Enter Phone Number",
            "phone.regex" => "Please Enter Phone Number Correct",
            "address.required" => "Please Enter Address",
            "address.string" => "Please Enter Address Correct",
        ]);
        // Get phone and address after validation
        $Phone = $data["phone"];
        $Address = $data["address"];
        // Get user ID
        $user = Auth::user();
        $user_id = $user->id;
        // Get user's carts
        $carts = Cart::where('user_id', "$user_id")->get();
        // Create order for each cart item
        foreach ($carts as $cart) {
            $order = new Order();
            $order->Address = $Address;
            $order->Phone = $Phone;
            $order->Address = $Address;
            $order->user_id = $user_id;
            $order->product_id = $cart->product_id;
            $order->total = $cart->total;
            $order->quantity = $cart->quantity;
            $order->Payment_status = "Cash";
            $order->Value_Status = "3";
            $order->Status = "In Progress";
            $order->save();
        }
        // Delete carts after placing order
        $empty_cart = Cart::where('user_id', "$user_id")->get();
        foreach ($empty_cart as $empty) {
            $data = Cart::find($empty->id);
            $data->delete();
        }
        // Flash success message and redirect back
        session()->flash("success", "Order Successfully");
        return redirect()->back();
    }

    public function delete_Cart($id)
    {
        // Find cart item by ID
        $cart_product = cart::findOrFail($id);
        // Delete cart item
        $cart_product->Forcedelete();
        // Flash success message and redirect back
        session()->flash("success", "delete Item from Cart Successfully");
        return redirect()->back();
    }

    public function logout()
    {
        // Logout user and redirect to login page
        Auth::logout();
        return view("auth.login");
    }
}
