@extends('admin.layout')

@section('body')
@include('success')
<table class="table">
    <thead>
        <td>{{__("message.Name")}}</td>
        <td>{{__("message.Desc")}}</td>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>
                {{ $category->name }}
            </td>
            <td>
                {{$category->desc}}
            </td>
            <td>
                <a href="{{url("categories/show/$category->id")}}">
                    <div class="btn btn-info">{{__("message.Show")}}</div>
                </a>
                <a href="{{url("categories/edit/$category->id")}}">
                    <div class="btn btn-success">{{__("message.Edit")}}</div>
                </a>
                <form action="{{url("categories/delete/$category->id")}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger mt-2">{{__("message.Delete")}}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$categories->links()}}
@endsection