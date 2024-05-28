@extends('admin.layout')

@section('body')

    <div class="container w-50">
        <h2 class="mt-3"> {{__("message.Add New Product")}} </h2>
        @include("error")
        <form action="{{url("products")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Product Name")}}</label>
                <input type="text" name="name" value="{{old("name")}}" placeholder="{{__("message.Product Name")}}" class="form-control"><br>
            </div>

            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Product Desc")}}</label>
                <textarea type="text" name="desc" placeholder="{{__("message.Product Desc")}}" class="form-control">{{old("name")}}</textarea>
            </div>
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Product Price")}}</label>
                <input type="number" name="price" value="{{old("price")}}" placeholder="{{__("message.Product Price")}}" class="form-control"><br>
            </div>
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Product Quantity")}}</label>
                <input type="text" name="quantity" value="{{old("quantity")}}" placeholder="{{__("message.Product Quantity")}}" class="form-control"><br>
            </div>

            <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">{{__("message.Product Category")}}</label>
                <select name="category_id" class="form-control" id="">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}"> {{$category->name}}  </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">{{__("message.Product Image")}}</label>
            <input type="file" name="image" class="form-control"><br>
            </div>
            <button type="submit" name="submit" class="btn btn-success">{{__("message.Add Product")}}</button>
        </form>
    </div>
@endsection