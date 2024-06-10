@extends('admin.layout')

@section('body')
    {{-- fix this and show it as a card  --}}

    <div class="card">
        <div class="card-body">
            <a class="btn btn-info mb-2" href="{{ url('products') }}">{{ __('message.Show All Products') }}</a>
            <a class="btn btn-primary mb-2" href="{{ url('products/create') }}">{{ __('message.Add Product') }}</a>

            <h3 class="mt-2">Show Product</h3>
            <p>{{ __('message.Product Name') }}: {{ $product->name }}</p>
            <p>{{ __('message.Product Desc') }}: {{ $product->desc }}</p>
            <p>{{ __('message.Product Image') }}:</p>
            <img src="{{ asset("storage/$product->image") }}" alt="" style="width: 200px">
            <p>{{ __('message.Product Price') }}: {{ $product->price }}</p>
            <p>Discount: {{ $product->Discount }}</p>
            <p>{{ __('message.Product Quantity') }}: {{ $product->quantity }}</p>
            <a class="btn btn-warning mt-2" href="{{ url("products/edit/$product->id") }}">{{ __('message.Edit') }}</a>
            <form action="{{ url("products/delete/$product->id") }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger mt-2">{{ __('message.Delete') }}</button>
            </form>
        </div>
    </div>

    {{-- Make div to show all review of this products --}}
    <div class="mt-4" id="reviews">
        <h2>Reviews</h2>
        @forelse ($product->reviews as $review)
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
                        <div class="col-md-10">
                            <p>{{ $review->review }}</p>
                        </div>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $review->created_at->format('M d, Y') }}</h6>

                    {{-- <div class="form-check form-switch ml-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
                    </div> --}}
                </div>
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>
@endsection
