@extends('user.layout')

@section('title')
<title> Show {{$cart->product->name}} </title>
@endsection

@section('latest')
@include('success')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card text-center p-4" style="width: 30rem; font-size: 1.5rem;">
    <img src="{{ asset('storage/' . $cart->product->image) }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{$cart->product->name}}</h5>
      <p class="card-text">{{$cart->product->desc}}</p>
      <p class="card-text text-muted"><bold>@if ($cart->product->Discount != 0.00)
        <h5 style="color: green;">
            $@php
                $priceAfterDiscount = $cart->product->price - $cart->product->Discount;
                echo $priceAfterDiscount;
            @endphp
        </h5>
        <h6 style="text-decoration: line-through; color: red;">
            ${{ $cart->product->price }}
        </h6>
    @else
        <h6 style="color: green;">
            ${{ $cart->product->price }}
        </h6>
    @endif</bold></p>
      <form method="POST" action="{{url("cart/update/$cart->id")}}">
        @csrf
        <div class="row">
            <div class="d-flex justify-content-center" style="margin-left: 20px">
                <input type="number" name ="quantity" value="{{$cart->quantity}}" min="1" style="width:100px">
            </div>
            <div class="d-flex justify-content-center" style="margin-left: 15px" >
                <button type="submit" class="btn btn-primary">Update Cart</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection