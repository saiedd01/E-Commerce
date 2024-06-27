<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            // call function Count
            $countCart = User::getCartCount();

            $countWishlist = User::getWishlistCount();
            // Return view with products and cart count
            return view("user.all", compact("products", "countCart", "countWishlist"));
        }
    }

    public function all()
    {
        // Get all products
        $products = Product::paginate(6);

        // call function Count
        $countCart = User::getCartCount();

        $countWishlist = User::getWishlistCount();

        // Return view with products and cart count
        return view("user.all", compact("products", "countCart", "countWishlist"));
    }

    public function show($id)
    {
        // Find product by ID
        $product = Product::findOrFail($id);

        // call function Count
        $countCart = User::getCartCount();

        $countWishlist = User::getWishlistCount();

        // Return view with product and cart count
        return view("user.show", compact("product", "countCart", "countWishlist"));
    }

    public function search(Request $request)
    {
        // call function Count
        $countCart = User::getCartCount();

        $countWishlist = User::getWishlistCount();

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
            return view("user.all", compact("products", "countCart", "countWishlist"));
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

            $countCart = User::getCartCount();

            $countWishlist = User::getWishlistCount();
            // Get user's carts
            $carts = Cart::where('user_id', "$user_id")->get();
            // Return view with carts and cart count
            return view("user.Cart", compact('carts', "countCart", "countWishlist", "user"));
        } else {
            // If not authenticated, redirect to login page
            return view("auth.login");
        }
    }

    public function Confirm_Order(Request $request)
    {
        $request->validate([
            "phone" => "required|string|regex:/^[0-9]{11,15}$/",
            "address" => "required|string|max:255",
        ], [
            "phone.required" => "Please enter a phone number.",
            "phone.regex" => "Please enter a valid phone number.",
            "address.required" => "Please enter an address.",
            "address.string" => "Please enter a valid address.",
        ]);

        $phone = $request->input("phone");
        $address = $request->input("address");

        $user = Auth::user();
        $user_id = $user->id;

        // Get user's carts
        $carts = Cart::where('user_id', $user_id)->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->withErrors('No items in cart.');
        }

        foreach ($carts as $cart) {
            $product = Product::findOrFail($cart->product_id);

            if ($product->quantity < $cart->quantity) {
                // Handle insufficient quantity scenario
                session()->flash("error", "Insufficient stock for {$product->name}.");
                return redirect()->back();
            }

            // Create order
            $order = new Order();
            $order->user_id = $user_id;
            $order->product_id = $cart->product_id;
            $order->quantity = $cart->quantity;
            $order->total = $cart->total;
            $order->Address = $address;
            $order->Phone = $phone;
            $order->Payment_status = "Cash";
            $order->Value_Status = "3";
            $order->Status = "In Progress";
            $order->save();

            // Update product quantity
            $product->quantity -= $cart->quantity;
            $product->save();
        }

        // Delete carts after placing order
        Cart::where('user_id', $user_id)->delete();

        // Flash success message and redirect back
        session()->flash("success", "Order successfully placed.");
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

    public function editCart($id)
    {
        // call function Count
        $countCart = User::getCartCount();

        $countWishlist = User::getWishlistCount();

        $cart = Cart::findorfail($id);
        // $product = Product::findorFail($id);
        return view("user.editCart", compact("cart", "countCart", "countWishlist"));
    }

    public function updateCart(Request $request, $id)
    {
        // Find the cart item or throw an exception if not found
        $cart = Cart::findorFail($id);

        // Update cart item quantity based on request data
        $cart->quantity = $request->quantity;

        // Calculate total price based on product price and potential discount
        $priceAfterDiscount = $cart->product->price - $cart->product->Discount;
        $cart->total = $priceAfterDiscount > 0 ? $priceAfterDiscount * $request->quantity : $cart->product->price * $request->quantity;

        // Update the cart item in the database
        $cart->update(); // Assuming your Cart model uses `save` method

        // Flash a success message for user feedback
        session()->flash('success', 'Cart Updated Successfully!');

        // Redirect user to the cart page
        return redirect('MyCart');
    }

    public function Review(Request $request)
    {
        $data = $request->validate([
            "rating" => 'required|integer|min:1|max:5',
            "review" => "required|string",
        ]);

        $data["product_id"] = $request->id;
        $data["user_id"] = Auth::user()->id;

        Review::create($data);
        session()->flash("success", "your Reviwe is submitted successfully");
        return redirect()->back();
    }

    public function Sort(Request $request)
    {
        $sortBy = 'name'; // Default sorting by name
        $sortOrder = 'asc'; // Default sorting order ascending

        // Determine sorting parameters based on the sort value
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $sortBy = 'name';
                    $sortOrder = 'asc';
                    break;
                case 'name_desc':
                    $sortBy = 'name';
                    $sortOrder = 'desc';
                    break;
                case 'price_asc':
                    $sortBy = DB::raw('price - Discount');
                    $sortOrder = 'asc';
                    break;
                case 'price_desc':
                    $sortBy = DB::raw('price - Discount');
                    $sortOrder = 'desc';
                    break;
            }
        }

        // Fetch products with sorting and pagination
        $products = Product::orderBy($sortBy, $sortOrder)->paginate(6);

        // Call function Count
        $countCart = User::getCartCount();
        $countWishlist = User::getWishlistCount();

        // Return view with products and cart count
        return view("user.all", compact("products", "countCart", "countWishlist"));
    }

    public function logout()
    {
        $userId = Auth::id();  // Retrieve user ID before logging out
        Auth::logout();

        $cart = Cart::where('user_id', $userId);
        $cart->forcedelete(); // Delete user's cart items

        $products = Product::paginate(6);
        return redirect("/")->with("products", $products);
    }
}
