<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function all(){
        $products = Product::paginate(5);
        return view("admin.Proudcts.Allproduct",compact("products"));
    }

    public function show($id){
        $product = Product::findorfail($id);
        return view("admin.Proudcts.show",compact("product"));
    }

    public function create(){
        $categories = Category::all();
        return view("admin.Proudcts.create")->with(["categories"=>$categories]);
    }

    public function store(Request $request){
        $data = $request->validate([
            "name"=>"required|string|max:200",
            "desc"=>"required|string",
            "image"=>"image|mimes:png,jpg,jpeg",
            "price"=>"required|numeric",
            // "Discount"=>"numeric",
            "quantity"=>"required|numeric",
            "category_id"=>"required|exists:categories,id"
        ]);
        $data['Discount']=$request->Discount;
        $data['image']=Storage::putFile('products',$data['image']);
        Product::create($data);
        session()->flash("success","product added!!!");
        return redirect(url("products"));
    }

    public function edit($id){
        $product = Product::findorFail($id);
        $categories = Category::all();
        return view("admin.Proudcts.edit")->with("product",$product)->with("categories",$categories);
    }

    public function update(Request $request , $id){
    // dd($request->Discount);
            $data = $request->validate([
            "name"=>"required|string|max:200",
            "desc"=>"required|string",
            "image"=>"image|mimes:png,jpg,jpeg",
            "price"=>"required|numeric",
            // "Discount"=>"numeric",
            "quantity"=>"required|numeric",
            "category_id"=>"required|exists:categories,id"
        ]);

        // check
        $product=Product::findOrfail($id);

        if($request->has("image")){
            Storage::delete($product->image);
            $data['image']=Storage::putFile('products',$data['image']);
        }
        $data['Discount']=$request->Discount;
       $product->update($data);
        session()->flash("success","product updated!!!");
        return redirect(url("products/show/$id"));
    }

    public function delete($id){
        $product =  Product::findOrFail($id);

        // Storage::delete($product->image);
        $product->delete();

        session()->flash("success","product deleted!!!");
        return redirect(url("products"));
    }
}
