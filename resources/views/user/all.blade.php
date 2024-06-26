@extends('user.layout')

@section('title')
    <title> {{ __('message.All Products') }} </title>
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
                    {{-- Sort Form --}}
                    <form action="{{ url('sort') }}" method="post" class="mb-4">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <div class="btn-group" role="group" aria-label="Sort by Name">
                                <button type="submit" name="sort" value="name_asc"
                                    class="btn btn-outline-secondary">Name ASC</button>
                                <button type="submit" name="sort" value="name_desc"
                                    class="btn btn-outline-secondary">Name DESC</button>
                            </div>
                            <div class="btn-group" role="group" aria-label="Sort by Price">
                                <button type="submit" name="sort" value="price_asc"
                                    class="btn btn-outline-secondary">Price ASC</button>
                                <button type="submit" name="sort" value="price_desc"
                                    class="btn btn-outline-secondary">Price DESC</button>
                            </div>
                        </div>
                    </form>
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
                                    @php
                                        $averageRating = $product->averageRating();
                                        $fullStars = floor($averageRating);
                                        $halfStar = $averageRating - $fullStars >= 0.5;
                                    @endphp
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $fullStars)
                                            <li><i class="fa fa-star"></i></li>
                                        @elseif ($halfStar)
                                            <li><i class="fa fa-star-half-alt"></i></li>
                                            @php $halfStar = false; @endphp
                                        @else
                                            <li><i class="far fa-star"></i></li>
                                        @endif
                                    @endfor
                                </ul>
                                <a href="{{ route('Show', ['id' => $product->id]) }}#reviews"><span>{{ __('message.Reviews') }}
                                        ({{ $product->reviewCount() }})
                                    </span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{ $products->links() }}
@endsection
