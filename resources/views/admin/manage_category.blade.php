@extends('admin/layout')
@section('title','Manage Category')
@section('category_select','active')
@section('container')
<h1 class="mb20">Add Category</h1>
<a href="{{url('admin/category')}}">
    <button type="button" class="btn btn-success">Back</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('category.manage_category_process')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="category_name" class="control-label mb-1">Category</label>
                            <input id="category_name"  value = "{{$category_name}}" name="category_name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('category_name')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group has-success">
                            <label for="slug" class="control-label mb-1">Category Slug</label>
                            <input id="slug" name="slug" value = "{{$slug}}"  type="text" class="form-control cc-name valid" required/>
                            @error('slug')
                            <div class="alert alert-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                               Submit
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{$id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    