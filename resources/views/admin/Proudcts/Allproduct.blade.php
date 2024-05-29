@extends('admin.layout')

@section('body')
    @include('success')
    <table class="table">
        <thead>
            <td>{{ __('message.Name') }}</td>
            <td>{{ __('message.Price') }}</td>
            <td>Discount</td>
            <td>{{ __('message.Quantity') }}</td>
            <td>{{ __('message.Image') }}</td>
            <td>{{ __('message.Action') }}</td>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        ${{ $product->price }}
                    </td>
                    <td>
                        @if ($product->Discount == null)
                            $0.00
                        @else
                            ${{ $product->Discount }}
                        @endif
                    </td>
                    <td>
                        {{ $product->quantity }}
                    </td>
                    <td width="20%">
                        <img src="{{ asset("storage/$product->image") }}" alt="" style="width: 30%; height: auto;">
                    </td>
                    <td>
                        <a href="{{ url("products/show/$product->id") }}">
                            <div class="btn btn-info">{{ __('message.Show') }}</div>
                        </a>
                        <a href="{{ url("products/edit/$product->id") }}">
                            <div class="btn btn-success">{{ __('message.Edit') }}</div>
                        </a>
                        <form action="{{ url("products/delete/$product->id") }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger mt-2">{{ __('message.Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
@endsection
