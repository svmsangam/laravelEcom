@extends('admin/layout')
@section('title','Banner')
@section('banner_select','active')
@section('container')
@if (session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissable fade show" role="alert">
    <span class="badge badge-pill badge-success">Success</span>
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">x</span></button>
</div>    
@endif
<h1 class="mb20">Banner</h1>
<a href="{{url('admin/banner/manage_banner')}}" class="mb20">
    <button type="button" class="btn btn-success">Add Banner</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Banner Image</th>
                        <th>Button Text</th>
                        <th>Button Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $banner)
                        <tr>
                            <td>{{$banner->id}}</td>
                            <td>
                                <img width="100px" src="{{asset('storage/media/banners/'.$banner->image )}}" alt="{{$banner->btn_text}}"/>
                            </td>
                            <td>{{$banner->btn_text}}</td>
                            <td>{{$banner->btn_link}}</td>
                            <td>
                                <a href="{{url('admin/banner/manage_banner/')}}/{{$banner->id}}"><button type="button" class="btn btn-success">Edit</button></a>
                                <a href="{{url('admin/banner/delete/')}}/{{$banner->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
                                @if ($banner->status==1)
                                <a href="{{url('admin/banner/status/0')}}/{{$banner->id}}"><button type="button" class="btn btn-info">Active</button></a>
                                @endif
                                @if ($banner->status==0)
                                <a href="{{url('admin/banner/status/1')}}/{{$banner->id}}"><button type="button" class="btn btn-warning">Deactive</button></a>
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
    