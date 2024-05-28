@extends('user.layout')

@section('title')
<title> Show {{$product->name}} </title>
@endsection

@section('latest')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card text-center p-4" style="width: 30rem; font-size: 1.5rem;">
    <img src="{{asset("storage/$product->image")}}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{$product->name}}</h5>
      <p class="card-text">{{$product->desc}}</p>
      <p class="card-text text-muted"><bold> Price :${{number_format($product->price,2)}}</bold></p>
      <form method="POST" action="{{url("add_to_cart/$product->id")}}">
        @csrf
        <div class="row">
            <div class="d-flex justify-content-center" style="margin-left: 20px">
                <input type="number" name ="quantity" value="1" min="1" style="width:100px">
            </div>
            <div class="d-flex justify-content-center" style="margin-left: 15px" >
                <button type="submit" class="btn btn-primary">Add To Cart</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection