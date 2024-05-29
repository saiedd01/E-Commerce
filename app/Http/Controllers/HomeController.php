<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth::user()->role==1){
            return view("admin.all");
        }else{
            $products = Product::paginate(6);
            return view("user.all",compact("products"));
        }
    }

    // all
    public function all(){
        $products = Product::paginate(6);
        return view("user.all",compact("products"));
    }

    public function show($id){
            $product = Product::findorfail($id);
            return view("user.show",compact("product"));
    }

    public function addToCart(Request $request,$id){

        if(Auth::id()){
            $user = Auth::user();
            $product = Product::findorfail($id);

            $cart = New cart();
            $cart->user_id=$user->id;
            $cart->email = $user->email;
            $cart->product_id=$product->id;
            $cart->product=$product->name;
            $cart->quantity=$request->quantity;
            $cart->price = $product->price;
            $cart->total = $product->price * $request->quantity;
            $cart->image=$product->image;
            $cart->save();
            $carts = cart::where('user_id',"$id")->get();
            session()->flash("success","Add product to Cart Successfully");
            return redirect(url("Show_Cart"));
        }else{
            return view("auth.login");
        }
    }

    public function search(Request $request){
        $search = $request->key;
        $products = Product::where("name",'like',"%$search%")->paginate(3);
        if($products->isEmpty()){
            session()->flash('error', 'Product Not Found');
            return redirect()->back();

        }else{
            return view("user.all",compact("products"));
        }
    }

    public function Show_Cart(){
        if(Auth::id()){
            $id = Auth::user()->id;
            $carts = cart::where('user_id',"$id")->get();
            return view("user.Cart",compact('carts'));
        }else{
            return view("auth.login");
        }
    }

    public function delete_Cart($id){
        $cart_product = cart::findOrFail($id);
        $cart_product->Forcedelete();
        session()->flash("success","delete Item from Cart Successfully");
        return redirect()->back();
    }

    public function logout(){
        Auth::logout();
        return view("auth.login");

    }
}
