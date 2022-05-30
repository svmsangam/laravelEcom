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
                <h2 class="mb-2">Product Attributes</h2>
                <div class="col-lg-12" id="product_attr_box">
                    @php
                    $loop_count_num=1;
                    @endphp 
                    @foreach($prodAttrArr as $key=>$val)
                    @php
                        $loop_count_prev = $loop_count_num;
                        $pAArr = (array)$val;
                    @endphp
                    <input id="prodAId"  name="prodAId[]" type="text" value="{{$pAArr['id']}}"/>
                    <div class="card" id="product_attr_{{$loop_count_num++}}">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                        <div class="col-md-2">
                                            <label for="sku" class="control-label mb-1">SKU</label>
                                            <input id="sku"  name="sku[]" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['sku']}}" required/>
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="mrp" class="control-label mb-1">MRP</label>
                                            <input id="mrp"  name="mrp[]" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['mrp']}}"  required/>
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="price" class="control-label mb-1">Price</label>
                                            <input id="price"  name="price[]" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['price']}}"  required/>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="quantity" class="control-label mb-1">Qty</label>
                                            <input id="quantity"  name="quantity[]" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['quantity']}}" " required/>
                                        </div>  
                                        <div class="col-md-3">
                                            <label for="size_id" class="control-label mb-1">Size</label>
                                            <select id="size_id" name="size_id[]"  type="text" class="form-control cc-name valid">
                                                <option >Select Size</option>
                                                @foreach($size as $sizeList)
                                                    @if($pAArr['size_id']==$sizeList->id)
                                                    <option value="{{$sizeList->id}}" selected>     
                                                        {{$sizeList->size}}
                                                    </option>
                                                    @else
                                                    <option value="{{$sizeList->id}}">     
                                                        {{$sizeList->size}}
                                                    </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="flavour_id" class="control-label mb-1">Flavours</label>
                                            <select id="flavour_id" name="flavour_id[]"  type="text" class="form-control cc-name valid">
                                                <option value="">Select Flavour</option>
                                                @foreach($flavour as $flavourList)
                                                @if($pAArr['flavour_id']==$flavourList->id)
                                                    <option value="{{$flavourList->id}}" selected>     
                                                        {{$flavourList->flavour}}
                                                    </option>
                                                @else
                                                    <option value="{{$flavourList->id}}">     
                                                        {{$flavourList->flavour}}
                                                    </option>
                                                @endif    
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="color_id" class="control-label mb-1">Color</label>
                                            <select id="color_id" name="color_id[]"  type="text" class="form-control cc-name valid">
                                                <option value="">Select Color</option>
                                                @foreach($color as $colorList)
                                                @if($pAArr['color_id']==$colorList->id)
                                                    <option value="{{$colorList->id}}" selected>     
                                                        {{$colorList->color}}
                                                    </option>
                                                @else
                                                    <option value="{{$colorList->id}}">     
                                                        {{$colorList->color}}
                                                    </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="attr_image" class="control-label mb-1">Image</label>
                                            <input id="attr_image" value="" name="attr_image[]" type="file"
                                                class="form-control" aria-required="true" aria-invalid="false" required/>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="add" class="control-label mb-1">
                                                Action
                                            </label>
                                            @if($loop_count_num==2)
                                            <button type="button" class="btn btn-success btn-md" onclick="add_more()">
                                                <i class="fa fa-plus">&nbsp;Add</i></button>
                                            @else
                                            <a href="{{url('admin/product/product_attr_delete/')}}/{{$pAArr['id']}}/{{$id}}">
                                                <button type="button" class="btn btn-danger btn-md">
                                                <i class="fa fa-minus">&nbsp;Remove</i></button></a>  
                                            @endif      
                                        </div>    
                                </div>
                            </div>    
                        </div>
                    </div>
                    @endforeach
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
<script>
    var loop_count = 1;
    function add_more(){
        loop_count++;
        var html ='<input id="prodAId" name="prodAId[]" type="text"/><div class="card" id="product_attr_'+loop_count+'"><div class="card-body"><div class="form-group"><div class="row">';
            html+='<div class="col-md-2"><label for="sku" class="control-label mb-1">SKU</label><input id="sku" value="" name="sku[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required/></div>';
            html+='<div class="col-md-2"><label for="mrp" class="control-label mb-1">MRP</label><input id="mrp" value="" name="mrp[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required/></div>';
            html+='<div class="col-md-2"><label for="price" class="control-label mb-1">Price</label><input id="price" value="" name="price[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required/></div>';
            html+='<div class="col-md-2"><label for="quantity" class="control-label mb-1">Quantity</label><input id="quantity" value="" name="quantity[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required/></div>';
            var size_id_html = jQuery('#size_id').html();
            html+='<div class="col-md-3"><label for="size_id" class="control-label mb-1">Size</label><select id="size_id" name="size_id[]" class="form-control">'+size_id_html+'</select></div>';
            var flavour_id_html = jQuery('#flavour_id').html();
            html+='<div class="col-md-3"><label for="flavour_id" class="control-label mb-1">Flavour</label><select id="flavour_id" name="flavour_id[]" class="form-control">'+flavour_id_html+'</select></div>';
            var color_id_html = jQuery('#color_id').html();
            html+='<div class="col-md-3"><label for="color_id" class="control-label mb-1">Color</label><select id="color_id" name="color_id[]" class="form-control">'+color_id_html+'</select></div>';
            html+='<div class="col-md-4"><label for="attr_image" class="control-label mb-1">Image</label><input id="attr_image" value="" name="attr_image[]" type="file"class="form-control" aria-required="true" aria-invalid="false" required/></div>';
            html+='<div class="col-md-2"><label for="remove" class="control-label mb-1">Action</label><button type="button" class="btn btn-danger btn-md" onclick=remove_more("'+loop_count+'")><i class="fa fa-minus">&nbsp;Remove</i></button></div>';  
            html+='</div></div></div></div>';        
            jQuery('#product_attr_box').append(html);
    }
    function remove_more(loop_count){
        jQuery('#product_attr_'+loop_count).remove();
    }
</script>
@endsection
