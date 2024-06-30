@extends('user.layout')

@section('title')
    <title>
        Wishlist </title>
@endsection

@section('latest')
    <div class="row">
        <!--/div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-contenct-between">
                    </div>
                </div>
                <div class="card-body">
                    @include('success')
                    @include('error')
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Product</th>
                                    <th class="border-bottom-0">Price</th>
                                    <th class="border-bottom-0">Image</th>
                                    <th class="border-bottom-0">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($items as $cart)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $cart->user->name }}</td>
                                        <td>{{ $cart->product->name }}</td>
                                        <td>
                                            @if ($cart->product->Discount != 0.0)
                                                $@php
                                                    $priceAfterDiscount =
                                                        $cart->product->price - $cart->product->Discount;
                                                    echo $priceAfterDiscount;
                                                    $total = $priceAfterDiscount * $cart->quantity;
                                                @endphp
                                            @else
                                                @php
                                                    $total = $cart->product->price * $cart->quantity;
                                                @endphp
                                                ${{ $cart->product->price }}
                                            @endif
                                        </td>
                                        <td><img src="{{ asset('storage/' . $cart->product->image) }}"
                                                alt="{{ $cart->product->name }}" style="width: 40px; "></a></td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">actions<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    {{-- Add Product To Cart --}}
                                                    <form method="POST" action="{{ url("add_to_cart/{$cart->product->id}") }}">
                                                        @csrf
                                                        <div class="form-group text-center">
                                                            <input type="number" name="quantity" value="1"
                                                                min="1" class="form-control d-inline-block"
                                                                style="width: 80px; display: inline-block; margin-right: 10px;">
                                                            <button type="submit" class="btn btn-outline-primary">
                                                                <i class="fa-solid fa-cart-shopping"></i>
                                                                Add To Cart</button>
                                                        </div>
                                                    </form>
                                                    {{-- delete product --}}
                                                    <a class="dropdown-item" href="#" data-id="{{ $cart->id }}"
                                                        data-toggle="modal"
                                                        data-target="#delete_product_{{ $cart->id }}"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                                        Remove
                                                    </a>
                                                    </button>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- delete modal  --}}
@foreach ($items as $cart)
    <div class="modal fade" id="delete_product_{{ $cart->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">delete product from cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url("wishlist/delete/$cart->id") }}"method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> Are you sure about the delete? </h6>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach



{{-- delete --}}
<script>
    $('#delete_product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })
</script>
