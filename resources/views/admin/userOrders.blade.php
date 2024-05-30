@extends('admin.layout')

@section('body')
    {{-- i want to make page to show orders of user
        user Name
        Address of Order
        Phone
        Order Date
        Order Status
        table of Details of all order from this user --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- User Details Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>User Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                            <p><strong>Address:</strong> {{ $user->Address }}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>Orders</h3>
                    </div>
                    <div>
                        <h4>
                            <h5>Orders for {{ $user->name }}</h5>

                            @if ($orders->isEmpty())
                                <p>No orders found for this user.</p>
                            @else
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Order Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->Status }}</td>
                                        <td>{{ $order->Phone }}</td>
                                        <td>{{ $order->Address }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">Detials<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <p><strong>Order Quantity:</strong> {{ $order->quantity }}</p>
                                                    <p><strong>Price per Item:</strong>
                                                        $@if($order->product->Discount != 0.00)
                                                            @php
                                                                $priceAfterDiscount =
                                                                    $order->product->price - $order->product->Discount;
                                                            @endphp
                                                            <span>{{$priceAfterDiscount }}</span>
                                                        @else
                                                            <span>{{$order->product->price }}</span>
                                                        @endif
                                                    </p>
                                                    <p><strong>Total:</strong> ${{ $order->total }}</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            </tbody>
                            @endforeach
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
