@extends('admin/layout')
@section('title','Customer')
@section('customer_select','active')
@section('container')
@if (session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissable fade show" role="alert">
    <span class="badge badge-pill badge-success">Success</span>
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
</div>    
@endif
<h1 class="mb20">Customers</h1>
{{-- <a href="{{url('admin/user/manage_user')}}" class="mb20">
    <button type="button" class="btn btn-success">Users</button>
</a> --}}
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $customer)
                        <tr>
                            <td>{{$customer->id}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->mobile}}</td>
                            <td>{{$customer->city}}</td>
                            <td>
                                <a href="{{url('admin/customer/view_customer')}}/{{$customer->id}}"><button type="button" class="btn btn-danger">View</button></a>
                                @if ($customer->status==1)
                                <a href="{{url('admin/customer/status/0')}}/{{$customer->id}}"><button type="button" class="btn btn-info">Active</button></a>
                                @endif
                                @if ($customer->status==0)
                                <a href="{{url('admin/customer/status/1')}}/{{$customer->id}}"><button type="button" class="btn btn-warning">Deactive</button></a>
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
    