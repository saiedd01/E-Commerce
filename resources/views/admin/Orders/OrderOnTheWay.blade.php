@extends('admin.layout')

<style>
    .custom-card-body {
        padding: -50px;
        border-radius: 0.25rem;
        border: 3px;
        border-style: hidden;
        width: auto;
    }
</style>

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Orders List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
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
                                                    $@php
                                                        $priceAfterDiscount =
                                                            $order->product->price - $order->product->Discount;
                                                        echo $priceAfterDiscount;
                                                    @endphp
                                                @else
                                                    ${{ $order->product->price }}
                                                @endif
                                            </td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ $order->total }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $order->product->image) }}"
                                                    alt="{{ $order->product->name }}" style="width: 40px;"
                                                    class="img-fluid rounded-circle">
                                            </td>
                                            <td>
                                                @if ($order->Value_Status == 1)
                                                    <span class="badge badge-success">{{ $order->Status }}</span>
                                                @elseif ($order->Value_Status == 2)
                                                    <span class="badge badge-warning">{{ $order->Status }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $order->Status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                        type="button">actions<i
                                                            class="fas fa-caret-down ml-1"></i></button>
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
                                                        <form action="{{ url("products/Cancelled/$order->id") }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-danger mt-2">Cancel</button>
                                                        </form>
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($orders->isEmpty())
                            <p class="text-center mt-4">No orders found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
