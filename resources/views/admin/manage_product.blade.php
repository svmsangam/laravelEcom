@extends('admin/layout')
@section('title','Manage Product')
@section('product_select','active')
@section('container')
@php
    $image_required='';
    if($id>0)$image_required="";
    else
    $image_required="required";   
@endphp     
<h1 class="mb20">Add Product</h1>
<a href="{{url('admin/product')}}">
    <button type="button" class="btn btn-success">Back</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <form action="{{route('product.manage_product_process')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="form-group">
                                    <label for="name" class="control-label mb-1">Product</label>
                                    <input id="name"  value = "{{$name}}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('name')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group has-success">
                                    <label for="slug" class="control-label mb-1">Slug</label>
                                    <input id="slug" name="slug" value = "{{$slug}}"  type="text" class="form-control cc-name valid" required/>
                                    @error('slug')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group has-success">
                                    <label for="image" class="control-label mb-1">Image</label>
                                    <input id="image" name="image"  type="file" class="form-control cc-name valid" {{$image_required}}/>
                                    @error('image')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group has-success">
                                    <label for="category_id" class="control-label mb-1"> Category</label>
                                    <select id="category_id" name="category_id"  type="text" class="form-control cc-name valid" required>
                                        <option value="">Select Categories</option>
                                        @foreach($category as $list)
                                            @if($category_id==$list->id)
                                                <option selected value="{{$list->id}}">
                                            @else
                                                <option value="{{$list->id}}">
                                            @endif        
                                            {{$list->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group has-success">
                                    <label for="desc" class="control-label mb-1">Description</label>
                                    <textarea id="desc" name="desc" type="text" class="form-control cc-name valid" required>{{$desc}}</textarea>
                                    @error('desc')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group has-success">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="hasNoEgg" id="hasNoEgg" 
                                        value="1" {{$hasNoEgg || old('hasNoEgg', 0) === 1 ? 'checked':''}}>
                                        <label class="form-check-label" for="hasEgg">Contains No Egg?</label>
                                    </div>
                                </div>
                                <div class="form-group has-success">
                                    <label for="keywords" class="control-label mb-1">Keywords</label>
                                    <input id="keywords" name="keywords" value = "{{$keywords}}"  type="text" class="form-control cc-name valid" required/>
                                    @error('desc')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           <div class="row">
                                <div class="col-md-2">
                                    <label for="sku" class="control-label mb-1">SKU</label>
                                    <input id="sku" value="" name="sku" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required/>
                                </div> 
                                <div class="col-md-2">
                                    <label for="mrp" class="control-label mb-1">MRP</label>
                                    <input id="mrp" value="" name="mrp" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required/>
                                </div> 
                                <div class="col-md-2">
                                    <label for="price" class="control-label mb-1">Price</label>
                                    <input id="price" value="" name="price" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required/>
                                </div>
                                <div class="col-md-2">
                                    <label for="quantity" class="control-label mb-1">Qty</label>
                                    <input id="quantity" value="" name="quantity" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required/>
                                </div>  
                                <div class="col-md-3">
                                    <label for="size_id" class="control-label mb-1">Size</label>
                                    <select id="size_id" name="size_id"  type="text" class="form-control cc-name valid" required>
                                        <option value="">Select Size</option>
                                        @foreach($size as $sizeList)
                                            <option value="{{$sizeList->id}}">     
                                                {{$sizeList->size}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="flavour_id" class="control-label mb-1">Flavours</label>
                                    <select id="flavour_id" name="flavour_id"  type="text" class="form-control cc-name valid" required>
                                        <option value="">Select Flavour</option>
                                        @foreach($flavour as $flavourList)
                                            <option value="{{$flavourList->id}}">     
                                                {{$flavourList->flavour}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="color_id" class="control-label mb-1">Size</label>
                                    <select id="color_id" name="color_id"  type="text" class="form-control cc-name valid" required>
                                        <option value="">Select Color</option>
                                        @foreach($color as $colorList)
                                            <option value="{{$colorList->id}}">     
                                                {{$colorList->color}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="attr_image" class="control-label mb-1">Image</label>
                                    <input id="attr_image" value="" name="attr_image" type="file"
                                        class="form-control" aria-required="true" aria-invalid="false" required/>
                                </div>  
                           </div>    
                        </div>
                    </div>
                </div>
            </div>    
            <div>  
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                Submit
                </button>
                <input type="hidden" name="id" value="{{$id}}">
            </div>  
        </form>      
    </div>
</div>
@endsection
