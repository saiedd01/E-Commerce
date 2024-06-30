@extends('admin.layout')

@section('body')
    <div class="card">
        <div class="card-body">
            <a class="btn btn-info mb-2" href="{{ url('products') }}">{{ __('message.Show All Products') }}</a>
            <a class="btn btn-primary mb-2" href="{{ url('products/create') }}">{{ __('message.Add Product') }}</a>

            <h3 class="mt-2">Show Product</h3>
            <p>{{ __('message.Product Name') }}: {{ $product->name }}</p>
            <p>{{ __('message.Product Desc') }}: {{ $product->desc }}</p>
            <p>{{ __('message.Product Image') }}:</p>
            @if ($product->image)
                <img src="{{ asset("storage/$product->image") }}" alt="{{ $product->name }}" style="width: 200px;">
            @endif
            @if ($product->qr_code)
                <div>
                    <h3>QR Code</h3>
                    <img src="{{ asset("storage/$product->qr_code") }}" alt="QR Code for {{ $product->name }}"
                        style="width: 200px;">
                </div>
            @endif
            <p>{{ __('message.Product Price') }}: {{ $product->price }}</p>
            <p>Discount: {{ $product->Discount }}</p>
            <p>{{ __('message.Product Quantity') }}: {{ $product->quantity }}</p>
            <p>Category: {{ $product->category->name }}</p>
            <a class="btn btn-warning mt-2" href="{{ url("products/edit/$product->id") }}">{{ __('message.Edit') }}</a>
            <form action="{{ url("products/delete/$product->id") }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger mt-2">{{ __('message.Delete') }}</button>
            </form>
        </div>
    </div>

    {{-- Show all reviews of this product --}}
    <div class="mt-4" id="reviews">
        <h2>Reviews</h2>
        @forelse ($product->reviews as $review)
            @if ($review->deleted_at == null)
                {{-- Only show reviews that are not soft deleted --}}
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <h5 class="card-title">{{ $review->user->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <span class="text-warning">&#9733;</span>
                                        @else
                                            <span class="text-muted">&#9734;</span>
                                        @endif
                                    @endfor
                                </h6>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $review->review }}</p>
                            </div>
                            <div class="col-md-2">
                                @if ($review->visible)
                                    <form
                                        action="{{ route('products.reviews.hide', ['productId' => $product->id, 'reviewId' => $review->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hide</button>
                                    </form>
                                @else
                                    <form
                                        action="{{ route('products.reviews.show', ['productId' => $product->id, 'reviewId' => $review->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">Show</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $review->created_at->format('M d, Y') }}</h6>
                    </div>
                </div>
            @else
                <div class="card mt-3">
                    <div class="card-body">
                        <p>This review has been hidden.</p>
                    </div>
                </div>
            @endif
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>
@endsection
