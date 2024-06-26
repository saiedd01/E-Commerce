@extends('user.layout')

@section('title')
    <title> Home </title>
@endsection

@section('latest')
    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>{{ __('message.Latest Products') }}</h2>
                        <a href="products.html">{{ __('message.View all products') }} <i class="fa fa-angle-right"></i></a>
                    </div>
                    {{-- Error Msg --}}
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    {{-- Search --}}
                    <form action="{{ url('search') }}" method="get" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="key" class="form-control" placeholder="Search..."
                                aria-label="Search" aria-describedby="button-search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="button-search">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between">
                        <div class="btn-group" role="group" aria-label="Sort by Title">
                            <a href="{{ url('sort?by=title&order=asc') }}" class="btn btn-outline-secondary">Title ASC</a>
                            <a href="{{ url('sort?by=title&order=desc') }}" class="btn btn-outline-secondary">Title DESC</a>
                        </div>
                        <div class="btn-group" role="group" aria-label="Sort by Price">
                            <a href="{{ url('sort?by=price&order=asc') }}" class="btn btn-outline-secondary">Price ASC</a>
                            <a href="{{ url('sort?by=price&order=desc') }}" class="btn btn-outline-secondary">Price DESC</a>
                        </div>
                    </div>
                </div>
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="product-item">
                            <div class="container w-100 h-100 mx-2 my-1">
                                <a href="{{ route('Show', ['id' => $product->id]) }}">
                                    <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}"
                                        style="width: 50%;"></a>
                            </div>
                            <div class="down-content">
                                <a href="{{ route('Show', ['id' => $product->id]) }}">
                                    <h4>{{ $product->name }}</h4>
                                </a>
                                @if ($product->Discount != 0.0)
                                    <h5 style="color: green;">
                                        $@php
                                            $priceAfterDiscount = $product->price - $product->Discount;
                                            echo $priceAfterDiscount;
                                        @endphp
                                    </h5>
                                    <h6 style="text-decoration: line-through; color: red;">
                                        ${{ $product->price }}
                                    </h6>
                                @else
                                    <h6 style="color: green;">
                                        ${{ $product->price }}
                                    </h6>
                                @endif
                                <p>{{ $product->desc }}</p>
                                <ul class="stars">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <span>{{ __('message.Reviews') }} (24)</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{ $products->links() }}
@endsection
