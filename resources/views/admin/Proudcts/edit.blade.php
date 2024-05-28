@extends('admin.layout')

@section('body')

    <div class="container w-50">
        <h2 class="mt-3"> Edit {{$product->name}} </h2>
        @include("error")
        <form action="{{url("products/update/$product->id")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                <input type="text" name="name" value="{{$product->name}}" placeholder="Product Name" class="form-control"><br>
            </div>

            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">Product description</label>
                <textarea type="text" name="desc" placeholder="Product description" class="form-control">{{$product->desc}}</textarea>
            </div>
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">Product Price</label>
                <input type="number" name="price" value="{{$product->price}}" placeholder="Product Price" class="form-control"><br>
            </div>
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">Product Quantity</label>
                <input type="text" name="quantity" value="{{$product->quantity}}" placeholder="Product Quantity" class="form-control"><br>
            </div>

            <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">Product Category</label>
                <select name="category_id" class="form-control" id="">
                    {{-- <option value="{{$product->category_id}}"> {{$product->category->name}} </option> --}}
                    @foreach ($categories as $category)
                         <option value="{{$category->id}}" @if ($product->category_id== $category->id)
                            selected
                         @endif> {{$category->name}}  </option>
                     @endforeach
                </select>
            </div>

            <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">Image</label>
            <img src="{{asset("storage/$product->image")}}" alt="" style="width: 100px">
            <input type="file" name="image" class="form-control"><br>
            </div>
            <button type="submit" name="submit" class="btn btn-success"> Edit Product</button>
        </form>
    </div>
@endsection