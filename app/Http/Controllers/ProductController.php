<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function all()
    {
        $products = Product::paginate(5);
        return view("admin.Proudcts.Allproduct", compact("products"));
    }

    public function show($id)
    {
        $product = Product::findorfail($id);
        return view("admin.Proudcts.show", compact("product"));
    }

    public function create()
    {
        $categories = Category::all();
        return view("admin.Proudcts.create")->with(["categories" => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:200",
            "desc" => "required|string",
            "image" => "image|mimes:png,jpg,jpeg",
            "price" => "required|numeric",
            // "Discount"=>"numeric",
            "quantity" => "required|numeric",
            "category_id" => "required|exists:categories,id"
        ]);
        $data['Discount'] = $request->Discount;
        $data['image'] = Storage::putFile('products', $data['image']);
        $product = Product::create($data);

        // Define QR code path
        $qrCodeDir = storage_path('app/public/qrcodes');
        $qrCodePath = $qrCodeDir . '/' . $product->id . '.png';

        // Create directory if it doesn't exist
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        // Generate QR Code
        $productDetailUrl = route('Show', ['id' => $product->id]);
        QrCode::format('png')->generate($productDetailUrl, $qrCodePath);

        // Update product with QR Code path relative to storage/app/public/
        $product->update(['qr_code' => 'qrcodes/' . $product->id . '.png']);

        session()->flash("success", "product added!!!");
        return redirect(url("products"));
    }

    public function edit($id)
    {
        $product = Product::findorFail($id);
        $categories = Category::all();
        return view("admin.Proudcts.edit")->with("product", $product)->with("categories", $categories);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string|max:200",
            "desc" => "required|string",
            "image" => "image|mimes:png,jpg,jpeg",
            "price" => "required|numeric",
            // "Discount"=>"numeric",
            "quantity" => "required|numeric",
            "category_id" => "required|exists:categories,id"
        ]);

        // check
        $product = Product::findOrfail($id);

        if ($request->has("image")) {
            Storage::delete($product->image);
            $data['image'] = Storage::putFile('products', $data['image']);
        }
        $data['Discount'] = $request->Discount;
        $product->update($data);
        session()->flash("success", "product updated!!!");
        return redirect(url("products/show/$id"));
    }

    public function delete($id)
    {
        $product =  Product::findOrFail($id);
        // Storage::delete($product->image);
        $product->delete();
        session()->flash("success", "product deleted!!!");
        return redirect(url("products"));
    }

    public function allOrder()
    {
        // Retrieve all orders
        $orders = Order::all();

        // Return view with orders data
        return view("admin.Proudcts.AllOrder", compact("orders"));
    }

    public function onTheWay($id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Update order status to "On The Way" and value status to "2"
        $order->update([
            "Status" => "On The Way",
            "Value_Status" => "2"
        ]);

        // Flash success message and redirect to all orders page
        session()->flash("success", "Order updated!");
        return redirect(url("product/AllOrder"));
    }

    public function delivered($id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Update order status to "Delivered" and value status to "1"
        $order->update([
            "Status" => "Delivered",
            "Value_Status" => "1"
        ]);

        // Flash success message and redirect to all orders page
        session()->flash("success", "Order updated!");
        return redirect(url("product/AllOrder"));
    }

    public function cancelled($id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Delete the order
        $order->delete();

        // Flash success message and redirect to all orders page
        session()->flash("success", "Order cancelled!");
        return redirect(url("product/AllOrder"));
    }

    public function users()
    {
        // Retrieve all users with role 0
        $users = User::where("role", '0')->get();

        // Return view with users data
        return view("admin.allUsers", compact("users"));
    }

    public function userOrders($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Retrieve orders for the user
        $orders = $user->orders;

        // Return view with user and orders data
        return view("admin.userOrders", compact("user", "orders"));
    }
}
