<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function all(){
        $categories = Category::paginate(5);
        return view("admin.Categories.Allcatrgory",compact("categories"));
    }

    public function show($id){
        $category = Category::findorfail($id);
        return view("admin.Categories.show",compact("category"));
    }

    public function create(){
        return view("admin.Categories.create");
    }

    public function store(Request $request){
        $data = $request->validate([
            "name"=>"required|string|max:200",
            "desc"=>"required|string"
        ]);

        Category::create($data);
        session()->flash("success","Category added!!!");
        return redirect(url("categories"));
    }
    public function edit($id){
        $category = category::findorFail($id);
        return view("admin.Categories.edit")->with("category",$category);
    }

    public function update(Request $request , $id){
        $data = $request->validate([
            "name"=>"required|string|max:200",
            "desc"=>"required|string",
        ]);

        // check
        $category=category::findOrfail($id);
       $category->update($data);
        session()->flash("success","category updated!!!");
        return redirect(url("categories/show/$id"));
    }

    public function delete($id){
        $category =  category::findOrFail($id);
        $category->delete();
        session()->flash("success","category deleted!!!");
        return redirect(url("categories"));
    }
}
