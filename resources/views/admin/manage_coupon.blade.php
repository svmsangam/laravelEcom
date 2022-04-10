@extends('admin/layout')
@section('title','Manage Coupon')
@section('coupon_select','active')
@section('container')
<h1 class="mb20">Add Coupon</h1>
<a href="{{url('admin/coupon')}}">
    <button type="button" class="btn btn-success">Back</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('coupon.manage_coupon_process')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="control-label mb-1">Title</label>
                            <input id="title"  value = "{{$title}}" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('title')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="code" class="control-label mb-1">Code</label>
                            <input id="code"  value = "{{$code}}" name="code" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('code')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group has-success">
                            <label for="value" class="control-label mb-1">Value</label>
                            <input id="value" name="value" value = "{{$value}}"  type="text" class="form-control cc-name valid" required/>
                            @error('value')
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
    