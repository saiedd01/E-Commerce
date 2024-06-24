@extends('admin.layout')

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- User Details Card -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">User Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone }}</p>
                        <p><strong>Address:</strong> {{ $user->Address }}</p>
                    </div>
                </div>

                <!-- Orders Card -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">Orders for {{ $user->name }}</h3>
                    </div>
                    <div class="card-body">
                        @if ($orders->isEmpty())
                            <p class="text-center">No orders found for this user.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
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
                                                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                                <td>{{ $order->Status }}</td>
                                                <td>{{ $order->Phone }}</td>
                                                <td>{{ $order->Address }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle"
                                                            type="button" id="orderDetailsDropdown{{ $order->id }}"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Details <i class="fas fa-caret-down ml-1"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="orderDetailsDropdown{{ $order->id }}">
                                                            <p><strong>Order Quantity:</strong> {{ $order->quantity }}</p>
                                                            <p><strong>Price per Item:</strong>
                                                                $@if ($order->product->Discount != 0.0)
                                                                    @php
                                                                        $priceAfterDiscount =
                                                                            $order->product->price -
                                                                            $order->product->Discount;
                                                                    @endphp
                                                                    <span>{{ $priceAfterDiscount }}</span>
                                                                @else
                                                                    <span>{{ $order->product->price }}</span>
                                                                @endif
                                                            </p>
                                                            <p><strong>Total:</strong> ${{ $order->total }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
