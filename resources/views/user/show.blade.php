@extends('user.layout')

@section('title')
    <title>Show {{ $product->name }}</title>
@endsection

@section('latest')
    @include('success')
    @include('error')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card text-center p-4" style="width: 30rem; font-size: 1.5rem;">
            <img src="{{ asset("storage/$product->image") }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->desc }}</p>
                <p class="card-text text-muted">
                    <strong>
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
                    </strong>
                </p>
                <form method="POST" action="{{ url("add_to_cart/$product->id") }}">
                    @csrf
                    <div class="form-group text-center">
                        <input type="number" name="quantity" value="1" min="1"
                            class="form-control d-inline-block"
                            style="width: 80px; display: inline-block; margin-right: 10px;">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Add To Cart</button>
                    </div>
                    <div class="mt-2 text-center">
                        @if ($product->quantity > 0)
                            <span class="text-success small">In Stock</span>
                        @else
                            <span class="text-danger small">Out of Stock</span>
                        @endif
                    </div>
                </form>

                <div class="row mt-3">
                    <div class="col">
                        <button class="btn btn-outline-success btn-sm btn-block" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-toggle="modal" data-target="#review_Product">
                            <i class="fas fa-comment"></i> Make Review
                        </button>
                    </div>
                    <div class="col">
                        <form method="POST" action="{{ url("add_to_wishlist/$product->id") }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm btn-block">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-4" id="reviews">
        <h2>Reviews</h2>
        @forelse  ($product->reviews()->where('visible', '1')->get() as $review)
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
                </div>
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>




    {{-- Make Review --}}
    <div class="modal fade" id="review_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('submit_review') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rating">How many Stars?</label>
                            <select class="form-control" name="rating">
                                <option value=""> select </option>
                                <option value="1"> 1 </option>
                                <option value="2"> 2 </option>
                                <option value="3"> 3 </option>
                                <option value="4"> 4 </option>
                                <option value="5"> 5 </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea name="review" cols="20" rows="5" id="review" class="form-control"></textarea>
                        </div>
                        <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Make Review</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#review_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #id').val(id);
        });
    });
</script>
