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
                        <a class="dropdown-item" href="{{ url("products/show/$product->id") }}">
                            <img src="{{ asset("storage/$product->image") }}" alt=""
                                style="width: 30%; height: auto;">
                        </a>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm"
                                data-toggle="dropdown" type="button">actions<i class="fas fa-caret-down ml-1"></i></button>
                            <div class="dropdown-menu tx-13">
                                {{-- Show --}}
                                <a class="dropdown-item" href="{{ url("products/show/$product->id") }}">
                                    <i class="text-success fas fa-eye"></i>&nbsp;&nbsp;
                                    {{ __('message.Show') }}
                                </a>
                                {{-- Edit --}}
                                <a class="dropdown-item" href="{{ url("products/edit/$product->id") }}">
                                    <i class="text-primary fas fa-edit"></i>&nbsp;&nbsp;
                                    {{ __('message.Edit') }}
                                </a>
                                {{-- <form action="{{ url("products/delete/$product->id")}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger mt-2">{{ __('message.Delete') }}</button>
                                </form> --}}
                                <a class="dropdown-item" href="#" data-product_id="{{ $product->id }}"
                                    data-toggle="modal" data-target="#delete_product"><i
                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                    {{ __('message.Delete') }}
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- make button redircet to AllOrder page --}}
    <a href="{{ url('product/AllOrder') }}">
        <div class="btn btn-primary">All Order</div>
    </a>
    {{ $products->links() }}
@endsection
{{-- delete modal  --}}
@foreach ($products as $product)
    <div class="modal fade" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">delete product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url("products/delete/$product->id") }}" method="post">
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

<script>
    $('#delete_product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('product_id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })
</script>
