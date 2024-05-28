@extends('admin.layout')

@section('body')

    <div class="container w-50">
        <h2 class="mt-3"> {{__("message.Add New Category")}} </h2>
        @include("error")
        <form action="{{url("categories")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Category Name")}}</label>
                <input type="text" name="name" value="{{old("name")}}" placeholder="{{__("message.Category Name")}}" class="form-control"><br>
            </div>

            <div class="mb-1">
                <label for="exampleFormControlInput1" class="form-label">{{__("message.Category Desc")}}</label>
                <textarea type="text" name="desc" placeholder="{{__("message.Category Desc")}}" class="form-control">{{old("name")}}</textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-success">{{__("message.Add Category")}}</button>
        </form>
    </div>
@endsection