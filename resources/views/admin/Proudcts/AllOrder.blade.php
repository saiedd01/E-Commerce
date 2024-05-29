@extends('admin.layout')

@section('body')
    {{--  i want to make table to display the order details from Order taable --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Orders Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Change Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->Phone }}</td>
                                        <td>{{ $order->Address }}</td>
                                        <td>{{ $order->product->name }}</td>
                                        <td>
                                            @if ($order->product->Discount != 0.0)
                                                <h5>
                                                    $@php
                                                        $priceAfterDiscount =
                                                            $order->product->price - $order->product->Discount;
                                                        echo $priceAfterDiscount;
                                                    @endphp
                                                </h5>
                                            @else
                                                <h6>
                                                    ${{ $order->product->price }}
                                                </h6>
                                            @endif
                                        </td>
                                        <td><img src="{{ asset('storage/' . $order->product->image) }}"
                                                alt="{{ $order->product->name }}" style="width: 40px; "></a>
                                        </td>
                                        <td>{{$order->Status}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">actions<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    {{-- On the way --}}
                                                    <a href="{{ url("products/OnTheWay/$order->id") }}">
                                                        <div class="btn btn-warning">On The Way</div>
                                                    </a>
                                                    {{-- Delivered --}}
                                                    <a href="{{ url("products/Delivered/$order->id") }}">
                                                        <div class="btn btn-success">Delivered</div>
                                                    </a>
                                                    {{-- Cancelled --}}
                                                    <form action="{{ url("products/Cancelled/$order->id") }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger mt-2">Cancel</button>
                                                    </form>
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