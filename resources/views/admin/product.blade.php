@extends('admin/layout')
@section('title','Product')
@section('product_select','active')
@section('container')
@if (session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissable fade show" role="alert">
    <span class="badge badge-pill badge-success">Success</span>
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">x</span></button>
</div>    
@endif
<h1 class="mb20">Product</h1>
<a href="{{url('admin/product/manage_product')}}" class="mb20">
    <button type="button" class="btn btn-success">Add Product</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>
                                @if($product->image!='')
                                    <img width="100px" src="{{asset('storage/media/'.$product->image)}}" alt="{{$product->name." "."image"}}"/>
                                @endif
                            </td>
                            <td>{{$product->slug}}</td>
                            <td>
                                <a href="{{url('admin/product/manage_product/')}}/{{$product->id}}"><button type="button" class="btn btn-success">Edit</button></a>
                                <a href="{{url('admin/product/delete/')}}/{{$product->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
                                @if ($product->status==1)
                                <a href="{{url('admin/product/status/0')}}/{{$product->id}}"><button type="button" class="btn btn-info">Active</button></a>
                                @endif
                                @if ($product->status==0)
                                <a href="{{url('admin/product/status/1')}}/{{$product->id}}"><button type="button" class="btn btn-warning">Deactive</button></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>
@endsection
    