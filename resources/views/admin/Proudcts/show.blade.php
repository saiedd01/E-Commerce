@extends('admin.layout')

@section('body')
<a class="mt-4" href="{{url("products")}}">
    <div class="btn btn-info">{{__("message.Show All Products")}}</div>
</a>
<a class="mt-2" href="{{url("products/create")}}">
    <div class="btn btn-primary">{{__("message.Add Product")}}</div>
</a>

<h3 class= mt-2 >Show Product</h3>
{{(__("message.Product Name"))}} : {{$product->name}}  <br>
{{__("message.Product Desc")}} : {{$product->desc}}  <br>
{{__("message.Product Image")}} :
    <img src="{{asset("storage/$product->image")}}" alt="" style="width: 200px">
{{__("message.Product Price")}} : {{$product->price}}  <br>
Discount : {{$product->Discount}}  <br>
{{__("message.Product Quantity")}} : {{$product->quantity}}
<a class="mt-2" href="{{url("products/edit/$product->id")}}">
    <div class="btn btn-warning">{{__("message.Edit")}}</div>
</a>
<form action="{{url("products/delete/$product->id")}}" method="post">
    @csrf
    <button type="submit" class="btn btn-danger mt-2">{{__("message.Delete")}}</button>
</form>


@endsection