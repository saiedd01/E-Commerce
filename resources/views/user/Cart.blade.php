@extends('user.layout')

@section('title')
    <title>
        Cart </title>
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
                @php
                    $TotalOfCart = 0;
                @endphp
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
                                    <th class="border-bottom-0">Quantity</th>
                                    <th class="border-bottom-0">Image</th>
                                    <th class="border-bottom-0">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($carts as $cart)
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
                                        <td>{{ $cart->quantity }}</td>
                                        <td><img src="{{ asset('storage/' . $cart->product->image) }}"
                                                alt="{{ $cart->product->name }}" style="width: 40px; "></a></td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">actions<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    {{-- Edit Product --}}
                                                    <a class="dropdown-item" href="{{ url("cart/edit/$cart->id") }}"><i
                                                            class="text-primary fas fa-edit"></i>&nbsp;&nbsp;
                                                        Edit
                                                    </a>
                                                    {{-- delete product --}}
                                                    <a class="dropdown-item" href="#" data-id="{{ $cart->id }}"
                                                        data-toggle="modal"
                                                        data-target="#delete_product_{{ $cart->id }}"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                                        Delete
                                                    </a>
                                                    </button>
                                                </div>
                                        </td>
                                    </tr>
                                    @php
                                        $TotalOfCart = $TotalOfCart + $total;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="text-align: center">
        <h5> Total of Cart is : {{ $TotalOfCart }} </h5>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="{{ url('confirm_order') }}">
                    @csrf
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            @if ($user->carts->count() > 0) value="{{ $user->phone }}" @endif
                            placeholder="Enter your phone number">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="total" name="total" placeholder="Total"
                            value="{{ $TotalOfCart }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            @if ($user->carts->count() > 0) value="{{ $user->Address }}" @endif
                            placeholder="Enter your address">
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                </form>
            </div>
        </div>
    </div>
@endsection


{{-- delete modal  --}}
@foreach ($carts as $cart)
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
                <form action="{{ url("cart/delete/$cart->id") }}"method="post">
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

{{-- Edit --}}

<script>
    $('#edit_product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var Product_name = button.data('name')
        // var pro_id = button.data('pro_id')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #Product_name').val(Product_name);
        // modal.find('.modal-body #pro_id').val(pro_id);
    })
</script>

{{-- delete --}}
<script>
    $('#delete_product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })
</script>
