@extends('admin.layout')

@section('body')

    <div class="container w-50">
        <h2 class="mt-3"> {{__('message.Edit')}} {{$category->name}} </h2>
        @include("error")
        <form action="{{url("categories/update/$category->id")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Category Name")}}</label>
                <input type="text" name="name" value="{{$category->name}}" placeholder="{{__("message.Category Name")}}" class="form-control"><br>
            </div>

            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Category Desc")}}</label>
                <textarea type="text" name="desc" placeholder="{{__("message.Category Desc")}}" class="form-control">{{$category->desc}}</textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-success">{{__("message.Edit Category")}}</button>
        </form>
    </div>
@endsection