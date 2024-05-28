<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveProductController extends Controller
{
    public function index(){
        $products = Product::onlyTrashed()->get();
        return view('admin.Proudcts.Archive_Products', compact('products'));
    }

    public function update($id){
        $restore = Product::withTrashed()->where("id",$id);
        $restore->restore();
        session()->flash('success','Product Restored Successfully');
        return redirect(url("products"));
    }

    public function delete($id){
        $product =  Product::withTrashed()->where('id',$id);

        Storage::delete($product->image);
        $product->ForceDelete();

        session()->flash("success","product deleted!!!");
        return redirect(url("products"));
    }
}
