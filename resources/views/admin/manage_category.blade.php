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
                    <form action="{{route('category.manage_category_process')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="category_name" class="control-label mb-1">Category</label>
                                    <input id="category_name"  value = "{{$category_name}}" name="category_name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('category_name')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="slug" class="control-label mb-1">Category Slug</label>
                                    <input id="slug" name="slug" value = "{{$slug}}"  type="text" class="form-control cc-name valid" required/>
                                    @error('slug')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4"> 
                                    <label for="parent_category_id" class="control-label mb-1">Parent Category</label>
                                    <select id="parent_category_id" name="parent_category_id"  type="text" class="form-control cc-name valid">
                                        <option value="">Select Parent Category</option>
                                        @foreach($category as $list)
                                            @if($parent_category_id==$list->id)
                                                <option value="{{$list->id}}" selected>
                                            @else
                                                <option value="{{$list->id}}">
                                            @endif        
                                            {{$list->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="category_image" class="control-label mb-1">Category Image</label>
                                    <input id="category_image" name="category_image"  type="file" class="form-control cc-name valid"/>
                                    <div class="mt-2">
                                        @if($category_image !='')
                                        <img width="100px" src="{{asset('storage/media/categories/'.$category_image )}}" alt="{{$category_name}}"/>
                                        @endif
                                    </div>
                                    @error('category_image')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
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
    