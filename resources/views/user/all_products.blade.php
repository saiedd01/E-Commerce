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
                        <a href="#">{{ __('message.View all products') }} <i class="fa fa-angle-right"></i></a>
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
                    <form action="{{ url('sort') }}" method="get" class="mb-4">
                        <div class="dropdown">
                            <span>Sort By</span>
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Recommended
                            </button>
                            <div class="dropdown-menu" aria-labelledby="sortDropdown">
                                <button class="dropdown-item" type="submit" name="sort" value="price_asc">Price: LOW TO
                                    HIGH</button>
                                <button class="dropdown-item" type="submit" name="sort" value="price_desc">Price: HIGH
                                    TO LOW</button>
                                <button class="dropdown-item" type="submit" name="sort" value="avg_review_desc">Avg.
                                    Review</button>
                            </div>
                        </div>
                    </form>
                </div>
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="product-item">
                            <a href="{{ route('Show', ['id' => $product->id]) }}">
                                <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}"
                                    style="width: 100%;">
                            </a>
                            <div style="display: flex; justify-content: flex-end;">
                                <!-- Wishlist button/icon -->
                                <form method="POST" action="{{ url("add_to_wishlist/$product->id") }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="down-content">
                                <a href="{{ route('Show', ['id' => $product->id]) }}">
                                    <h4>{{ $product->name }}</h4>
                                </a>
                                <p>{{ Str::limit($product->desc, 100) }}</p>
                                <div class="price-container d-flex align-items-center" style="margin-top: -5px;">
                                    @if ($product->Discount != 0.0)
                                        <div style="display: flex; align-items: baseline;">
                                            <h5 style="color: green; margin: 0;">
                                                $@php
                                                    $priceAfterDiscount = $product->price - $product->Discount;
                                                    echo $priceAfterDiscount;
                                                @endphp
                                            </h5>
                                        </div>
                                        <div style="margin-left: 10px;">
                                            <h5 style="text-decoration: line-through; color: red; margin: 0;">
                                                ${{ $product->price }}
                                            </h5>
                                        </div>
                                        <h5 style="font-size: 14px; color: grey; margin-left: 5px;">
                                            ({{ round(($product->Discount / $product->price) * 100) }}% off)
                                        </h5>
                                    @else
                                        <div>
                                            <h5 style="color: green; margin: 0;">
                                                ${{ $product->price }}
                                            </h5>
                                        </div>
                                    @endif
                                </div>
                                <ul class="stars">
                                    @php
                                        $visibleReviews = $product->reviews()->where('visible', '1')->get();
                                        $averageRating = 0;
                                        $reviewCount = $visibleReviews->count();

                                        if ($reviewCount > 0) {
                                            $averageRating = $visibleReviews->avg('rating');
                                            $fullStars = floor($averageRating);
                                            $halfStar = $averageRating - $fullStars >= 0.5;
                                        } else {
                                            // No visible reviews, set fullStars and halfStar to 0
                                            $fullStars = 0;
                                            $halfStar = false;
                                        }
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

                                <a href="{{ route('Show', ['id' => $product->id]) }}#reviews">
                                    <span>{{ __('message.Reviews') }} ({{ $reviewCount }})</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
