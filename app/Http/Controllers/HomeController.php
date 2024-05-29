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
        if (Auth::user()->role == 1) {
            return view("admin.all");
        } else {
            $products = Product::paginate(6);
            if(Auth::id()){

                $user = Auth::user();
                $user_id = $user->id;
                $count = Cart::where("user_id", $user_id)->count();
            }else{
                $count = null;
            }
            return view("user.all", compact("products","count"));
        }
    }

    // all
    public function all()
    {
        $products = Product::paginate(6);
        if(Auth::id()){

            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
        }else{
            $count = null;
        }

        return view("user.all", compact("products", "count"));
    }

    public function show($id)
    {
        $product = Product::findorfail($id);
        if(Auth::id()){

            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
        }else{
            $count = null;
        }
        return view("user.show", compact("product", "count"));
    }

    public function search(Request $request){
        $search = $request->key;
        $products = Product::where("name", 'like', "%$search%")->paginate(3);
        if ($products->isEmpty()) {
            session()->flash('error', 'Product Not Found');
            return redirect()->back();
        } else {
            return view("user.all", compact("products"));
        }
    }

    public function addToCart(Request $request, $id){
        $product_id = Product::findorfail($id);
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart();
        $data->product_id = $product_id->id;
        $data->user_id = $user_id;
        $data->quantity=$request->quantity;
        $data->save();
        session()->flash("success", "Add product to Cart Successfully");
        return redirect()->back();
    }


    public function MyCart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where("user_id", $user_id)->count();
            // $id = Auth::user()->id;
            $carts = Cart::where('user_id', "$user_id")->get();
            return view("user.Cart", compact('carts',"count"));
        } else {
            return view("auth.login");
        }
    }

    public function Confirm_Order(Request $request){

        $Phone = $request->phone;
        $Address = $request->address;
        $user = Auth::user();
        $user_id = $user->id;
        $carts = Cart::where('user_id', "$user_id")->get();

        foreach($carts as $cart){
            $order = new Order();
            $order->Address = $Address;
            $order->Phone = $Phone;
            $order->Address = $Address;
            $order->user_id = $user_id;
            $order->product_id=$cart->product_id;
            $order->Payment_status="Cash";
            $order->Value_Status="2";
            $order->Status="In Progress";
            $order->save();
        }
        $empty_cart = Cart::where('user_id', "$user_id")->get();
        foreach($empty_cart as $empty){
            $data = Cart::find($empty->id);
            $data->delete();
        }
        session()->flash("success", "Order Successfully");
        return redirect()->back();
    }

    public function delete_Cart($id)
    {
        $cart_product = cart::findOrFail($id);
        $cart_product->Forcedelete();
        session()->flash("success", "delete Item from Cart Successfully");
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return view("auth.login");
    }
}
