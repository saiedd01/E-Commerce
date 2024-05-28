<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    public function all(){
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function show($id){
        $product = Product::find($id);

        // check
        if($product == null){
            return response()->json([
                "message" => "Product Not Found"
            ],404);
        }

        return new ProductResource($product);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:200",
            "desc"=>"required|string",
            "image"=>"image|mimes:png,jpg,jpeg",
            "price"=>"required|numeric",
            "quantity"=>"required|numeric",
            "category_id"=>"required|exists:categories,id"
        ]);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ],301);
        }

        $imageName = Storage::putFile("product",$request->image);

        Product::create([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$imageName,
            "category_id"=>$request->category_id,
        ]);

        return response()->json([
            "message" => "Product Added Successfully"
        ],201);
    }

    public function update(Request $request, $id){
        $product = Product::find($id);

        // check
        if(!$product == null){
            // validation
            $validator = Validator::make($request->all(),[
                "name"=>"required|string|max:200",
                "desc"=>"required|string",
                "image"=>"image|mimes:png,jpg,jpeg",
                "price"=>"required|numeric",
                "quantity"=>"required|numeric",
                "category_id"=>"required|exists:categories,id"
            ]);

            if($validator->fails()){
                return response()->json([
                    'errors'=>$validator->errors()
                ],301);
            }

            $imageName = $product->image; //old
            if ($request->has('image')) {
                // delete old image from storage folder
                Storage::delete($imageName);
                // upload new image to the
                $imageName = Storage::putFile("product",$request->image);
            }
            $product->update([
                "name"=>$request->name,
                "desc"=>$request->desc,
                "price"=>$request->price,
                "quantity"=>$request->quantity,
                "image"=>$imageName,
                "category_id"=>$request->category_id,
            ]);
            return response()->json([
                "message" => "Product Added Successfully",
                "product" => new  ProductResource($product)
            ],201);

        }else{
            return response()->json([
                "message" => "Product Not Found"
            ],404);
        }
    }

    public function delete($id){
        $product = Product::find($id);

        // check
        if(!$product == null){

            Storage::delete($product->image);  // Delete the image from storage/app/public/products

            $product->delete();   // Delete the product record from products table

            return response()->json([
                "message"=>"Product Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                "message" => "Product Not Found"
            ],404);
        }
    }
}
