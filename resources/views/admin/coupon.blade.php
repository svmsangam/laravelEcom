@extends('admin/layout')
@section('title','Coupon')
@section('coupon_select','active')
@section('container')
@if (session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissable fade show" role="alert">
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
</div>    
@endif
<h1 class="mb20">Coupon</h1>
<a href="{{url('admin/coupon/manage_coupon')}}" class="mb20">
    <button type="button" class="btn btn-success">Add Coupon</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Coupon Title</th>
                        <th>Value</th>
                        <th>Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $coupon)
                        <tr>
                            <td>{{$coupon->id}}</td>
                            <td>{{$coupon->title}}</td>
                            <td>{{$coupon->value}}</td>
                            <td>{{$coupon->code}}</td>
                            <td>
                                <a href="{{url('admin/coupon/manage_coupon/')}}/{{$coupon->id}}"><button type="button" class="btn btn-success">Edit</button></a>
                                <a href="{{url('admin/coupon/delete/')}}/{{$coupon->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
                                @if ($coupon->status==1)
                                <a href="{{url('admin/coupon/status/0')}}/{{$coupon->id}}"><button type="button" class="btn btn-info">Active</button></a>
                                @endif
                                @if ($coupon->status==0)
                                <a href="{{url('admin/coupon/status/1')}}/{{$coupon->id}}"><button type="button" class="btn btn-warning">Deactive</button></a>
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
    