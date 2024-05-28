@extends('admin.layout')

@section('body')
<a class="mt-4" href="{{url("categories")}}">
    <div class="btn btn-info">{{__("message.Show All Categories")}}</div>
</a>
<a class="mt-2" href="{{url("categories/create")}}">
    <div class="btn btn-primary">{{__("message.Add Category")}}</div>
</a>

<h3 class= mt-2 >{{__("message.Show Category")}}</h3>
{{__("message.Category Name")}} : {{$category->name}}  <br>
{{__("message.Category Desc")}} : {{$category->desc}}  <br>
<a class="mt-2" href="{{url("categories/edit/$category->id")}}">
    <div class="btn btn-warning">{{__("message.Edit")}}</div>
</a>
<form action="{{url("categories/delete/$category->id")}}" method="post">
    @csrf
    <button type="submit" class="btn btn-danger mt-2">{{__("message.Delete")}}</button>
</form>
@endsection