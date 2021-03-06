@extends('admin/layout')
@section('title','Size')
@section('size_select','active')
@section('container')
@if (session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissable fade show" role="alert">
    <span class="badge badge-pill badge-success">Success</span>
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
</div>    
@endif
<h1 class="mb20">Size</h1>
<a href="{{url('admin/size/manage_size')}}" class="mb20">
    <button type="button" class="btn btn-success">Add Size</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $size)
                        <tr>
                            <td>{{$size->id}}</td>
                            <td>{{$size->size}}</td>
                            <td>
                                <a href="{{url('admin/size/manage_size/')}}/{{$size->id}}"><button type="button" class="btn btn-success">Edit</button></a>
                                <a href="{{url('admin/size/delete/')}}/{{$size->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
                                @if ($size->status==1)
                                <a href="{{url('admin/size/status/0')}}/{{$size->id}}"><button type="button" class="btn btn-info">Active</button></a>
                                @endif
                                @if ($size->status==0)
                                <a href="{{url('admin/size/status/1')}}/{{$size->id}}"><button type="button" class="btn btn-warning">Deactive</button></a>
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
    